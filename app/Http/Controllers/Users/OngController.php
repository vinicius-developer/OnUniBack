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
use App\Utils\Api\ReceitaWs;
use App\Utils\Tools\Validators;
use Illuminate\Support\Facades\Auth;
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
            return response()->json($responsePassword, 401);
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

		if(!count($request->telefones)) {
			return response()->json([
				"message" => "The given data was invalid.",
  				"errors" => [
					"telefones" => "Pelo menos um telefone deve ser preenchido"
				]
			]);
		}

        $tbl_ongs->id_ongs = md5(uniqid(rand(), 'true'));
		$tbl_ongs->id_causas_sociais = $request->causa_social;
		$tbl_ongs->cnpj = $request->cnpj;
		$tbl_ongs->nome_fantasia = $request->nome_fantasia;
        $tbl_ongs->razao_social = $request->razao_social;
		$tbl_ongs->email = $request->email;
		$tbl_ongs->password = bcrypt($request->password); 
		$tbl_ongs->descricao_ong = $request->descricao;
		$tbl_ongs->img_perfil = 'pothoPerfilOng/fotoOngPadrao.png';
		$createOng = $tbl_ongs->save();

		$tbl_enderecos->id_ongs = $tbl_ongs->id_ongs;
		$tbl_enderecos->rua = $request->rua;
		$tbl_enderecos->cep = $request->cep;			
		$tbl_enderecos->numero = $request->numero;			
		$tbl_enderecos->complemento = $request->complemento;
		$tbl_enderecos->cidade = $request->cidade;
		$tbl_enderecos->bairro = $request->bairro;
		$tbl_enderecos->id_uf = $request->uf;
		$createEndereco = $tbl_enderecos->save();

		for($i = 0; $i < count($request->telefones); $i++) {
			$tbl_telefones = new Telefone();
			$tbl_telefones->numero_telefone = $request->telefones[$i];
		    $tbl_telefones->save();

			$tbl_relacao_telefones = new RelacaoTelefone();
			$tbl_relacao_telefones->id_doadores = null;
			$tbl_relacao_telefones->id_ongs = $tbl_ongs->id_ongs;
			$tbl_relacao_telefones->id_telefones = $tbl_telefones->id_telefones;

			$tbl_relacao_telefones->save();
		}
		
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
		$credential['password'] = $request->passowrd;
		$credential['status'] = 'true';

	    if (!$token = Auth::guard('ong')->attempt($credential)) {
            return response()->json([
				'message' => 'Não foi possível permitir a sua entrada',
				'errors' => [ 
					'Seus dados não foram encontrados em nosso sistema'
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

		$query = $user->select('id_causas_sociais',
								'cnpj',
								'nome_fantasia',
								'razao_social',
								'email',
								'descricao_ong',
								'img_perfil')->first();

        return response()->json($query);
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
        $ong = $this->ong
                    ->select(
                        'tbl_causas_sociais.nome_causa_social',
                        'tbl_ongs.cnpj',
                        'tbl_ongs.nome_fantasia',
                        'tbl_ongs.email',
                        'tbl_ongs.descricao_ong',
                        'tbl_ongs.img_perfil'
                    )->join('tbl_causas_sociais', 'tbl_causas_sociais.id_causas_sociais', '=', 'tbl_ongs.id_causas_sociais')
					->where('tbl_ongs.id_ongs', '=', $id)
					->first();

        return response()->json([$ong]);
    }

	protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('ong')->factory()->getTTL() * 200
        ]);
	}
}