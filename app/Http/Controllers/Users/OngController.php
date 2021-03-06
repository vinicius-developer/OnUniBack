<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\RelacaoTelefone;
use App\Models\LogTokenJwt;
use App\Http\Requests\Ong\RegisterOngRequest;
use App\Http\Requests\Ong\LoginOngRequest;
use App\Http\Requests\Ong\ImageOngRequest;
use App\Http\Requests\Ong\InfoOngRequest;
use App\Utils\Api\ReceitaWs;
use App\Utils\Tools\Validators;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\RegisterOngsMail;
use Mail;

class OngController extends Controller
{
	private $receitaWs;
	private $ong;
	
	public function __construct() 
	{
		$this->receitaWs = new ReceitaWS();
		$this->ong = new Ong();
 	}

	public function register(RegisterOngRequest $request)
	{
		$tbl_ongs = $this->ong;
		$tbl_enderecos = new Endereco();
		$validators = new Validators();

        $responsePassword = $validators->validatorPassword($request->password);

        if($responsePassword) {
            return response()->json($responsePassword, 422);
        }

		//$responseReceitaWs = $this->receitaWs->requestGetWs($cnpjOnlyNumbers); // NECESSÀRIO SOMENTE EM PRODUÇÃO
		// if($responseReceitaWs["situacao"] !== "ATIVA") {
		// 	return response()->json([
		// 		"message" => "The given data was invalid",
		//		"errors" => [
		//			"cnpj": [					
		//              "Esse Cnpj não está ativo"	
		//          ]
		
		// 	]);
		// }

        $tbl_ongs->id_ongs = md5(uniqid(rand(), 'true'));
		$tbl_ongs->id_causas_sociais = $request->causa_social;
		$tbl_ongs->cnpj = $request->cnpj;
		$tbl_ongs->nome_fantasia = $request->nome_fantasia;
        $tbl_ongs->razao_social = $request->razao_social;
		$tbl_ongs->email = $request->email;
		$tbl_ongs->password = bcrypt($request->password); 
		$tbl_ongs->descricao_ong = $request->descricao;
		$tbl_ongs->img_perfil = 'pothoPerfilOng/fotoOngPadrao.png';
		$tbl_ongs->save();

		$tbl_enderecos->id_ongs = $tbl_ongs->id_ongs;
		$tbl_enderecos->rua = $request->rua;
		$tbl_enderecos->cep = $request->cep;			
		$tbl_enderecos->numero = $request->numero;			
		$tbl_enderecos->complemento = $request->complemento;
		$tbl_enderecos->cidade = $request->cidade;
		$tbl_enderecos->bairro = $request->bairro;
		$tbl_enderecos->id_uf = $request->uf;
		$tbl_enderecos->save();

		$tbl_telefones = new Telefone();
		$tbl_telefones->numero_telefone = $request->telefone;
		$tbl_telefones->save();

		$tbl_relacao_telefones = new RelacaoTelefone();
		$tbl_relacao_telefones->id_doadores = null;
		$tbl_relacao_telefones->id_ongs = $tbl_ongs->id_ongs;
		$tbl_relacao_telefones->id_telefones = $tbl_telefones->id_telefones;
		$tbl_relacao_telefones->save();
		
		//Mail::send(new RegisterOngsMail($responseReceitaWs['email'], $responseReceitaWs[nome_fantasia], $tbl_ongs->id_ongs)); // ATIVAR SOMENTE EM PRODUÇÃO
		//Mail::send(new RegisterOngsMail($request->email, $request->nome_fantasia, $tbl_ongs->id_ongs)); // ATIVAR PARA TESTES
		return response()->json([
			"message" => 'Sua conta foi criado com sucesso! Por favor verifique o e-mail da ong que está cadastrado no CNPJ',
			"errors" => [],
		]);
	}

	public function activate($id) 
	{
		$user = $this->ong->select('*')->where('id_ongs','=', $id)->first();

		$user->status = 'true';
		$user->save();

		if($user) {
			return response()->json([
				"message" => "Sua conta foi ativada com sucesso",
				'errors' => []
			]);
		}
	}

	public function login(LoginOngRequest $request)
    {
		$credential['cnpj'] = $request->userkey;
		$credential['password'] = $request->password;
		$credential['status'] = 'true';

	    if (!$token = Auth::guard('ong')->attempt($credential)) {
            return response()->json([
				'message' => 'Não foi possível permitir a sua entrada',
				'errors' => [ 
					'password' => 'Seus dados não foram encontrados em nosso sistema'
				]
			], 401);
		}

		$log = new LogTokenJwt();

		$log->create([
			'token' => $token,
			'email' => $credential['cnpj'],
			'tipo_usuario' => 'ong'
		]);

        return $this->respondWithToken($token);
	}
	
	public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Você foi desconectado com sucesso']);
	}

	public function me()
    {
		$user = auth('ong')->user();

		$ong = $this->infoOng($user->id_ongs);

        return response()->json($ong);
    }
	
	public function index() 
	{
		$listOngs = $this->ong
						->join('tbl_causas_sociais', 'tbl_ongs.id_causas_sociais', '=', 'tbl_causas_sociais.id_causas_sociais')
						->where('tbl_ongs.status', '=', 'true')
				        ->select(
								'tbl_ongs.id_ongs as id',
    							'tbl_causas_sociais.nome_causa_social as nomeCausaSocial',
    							'tbl_ongs.cnpj as cnpj',
								'tbl_ongs.nome_fantasia as nomeFantasia',
    							'tbl_ongs.email as email',
								'tbl_ongs.descricao_ong as descricao',
                        		'tbl_ongs.img_perfil as img'
						)->paginate(5);

		return response()->json($listOngs);
	}

	public function find($id)
    {
        $ong = $this->infoOng($id);

        if($ong) {
			return response()->json($ong);
		} else {
			return response()->json([
				'message' => 'Esses dados não foram encontrados',
				'error' => [
					'Não conseguimos encontrar essa ong em nosso sistema'
				]], 400);
		}
	}
	
	public function changeImage(ImageOngRequest $request)
    {
		$user = Auth::guard('ong')->user();

        Storage::delete([$user->img_perfil]);
        $user->img_perfil = $request->file('photo')->store('pothoPerfilDoador');
        $response = $user->save();

        return  $response ? response()->json(['exists' => $response], 200) : response()->json(['exists' => $response], 500);
	}
	
	public function changeInfo(InfoOngRequest $request)
	{
		$user = Auth::guard('ong')->user();

		$camps = ['nome_fantasia', 'email', 'id_causas_sociais', 'descricao_ong'];

		if($request->att > (count($camps) - 1)) {
			return response()->json([
				'message' => 'Não foi possível atualizar essa informação',
				'errors' => [
					'Atributo informado não existe'
				]
				], 422);
		}


		$query = $this->ong->where('id_ongs', '=', $user->id_ongs)->update([$camps[$request->att] => $request->info]);

		return $query ? response()->json(['change' => true], 200) : response()->json(['exists' => false], 500);
	}

	protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('ong')->factory()->getTTL() * 200
        ]);
	}

	protected function infoOng($id)
	{

		return $this->ong
					->select(
						'tbl_causas_sociais.nome_causa_social as nomeCausaSocial',
						'tbl_ongs.nome_fantasia as nomeFantasia',
			  			'tbl_ongs.email as email',
						'tbl_ongs.descricao_ong as descricao',
						'tbl_ongs.img_perfil as img'
					)->join('tbl_causas_sociais', 'tbl_causas_sociais.id_causas_sociais', '=', 'tbl_ongs.id_causas_sociais')
					->where('tbl_ongs.id_ongs', '=', $id)
					->first();
	}
}