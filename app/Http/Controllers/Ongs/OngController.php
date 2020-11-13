<?php

namespace App\Http\Controllers\Ongs;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\RelacaoTelefone;
use App\Models\LogTokenJwt;
use App\Http\Requests\Ong\RegisterOngRequest;
use App\Http\Requests\Ong\LoginOngRequest;
use App\Utils\Api\ReceitaWs;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Mail;

class OngController extends Controller
{
	private $receitaWs;
	private $ong;
	public $loginAfterSingUp = true;
	
	public function __construct() 
	{
		$this->receitaWs = new ReceitaWS();
		$this->ong = new Ong();
 	}

	public function register(RegisterOngRequest $request)
	{
		$tbl_ongs = $this->ong;
		$tbl_enderecos = new Endereco();

		/* Mínimo de oito caracteres, pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial */
		$validatorPassword = preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $request->password);

		if(!$validatorPassword) {
			return response()->json([
				"message" => "The given data was invalid",
				"errors" => [
					"senha" => [
						"A senha deve conter no mínimo de oito caracteres, pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial"
					]
				]
			]);
		}

		//$responseReceitaWs = $this->receitaWs->requestGetWs($cnpjOnlyNumbers); // NECESSÀRIO SOMENTE EM PRODUÇÃO
		// if($responseReceitaWs["situacao"] !== "ATIVA") {
		// 	return response()->json([
		// 		"message" => "The given data was invalid",
		//		"errors" => [
		//			"cnpj": [					
		//              "Esse Cnpj não está ativo"	
		//          ]
		//	    ]
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
		$createOng = $tbl_ongs->save();

		$tbl_enderecos->id_ongs = $tbl_ongs->id_ongs;
		$tbl_enderecos->rua = $request->rua;
		$tbl_enderecos->cep = $request->cep;			
		$tbl_enderecos->numero = $request->numero;			
		$tbl_enderecos->complemento = $request->complemento;
		$tbl_enderecos->cidade = $request->cidade;
		$tbl_enderecos->bairro = $request->bairro;
		$tbl_enderecos->uf = $request->uf;
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
		
		if($createOng && $createEndereco) {
			//Mail::send(new \App\Mail\resgiterOngsMail($responseReceitaWs['email'], $responseReceitaWs[nome_fantasia], $tbl_ongs->id_ongs)); // ATIVAR SOMENTE EM PRODUÇÃO
			//Mail::send(new \App\Mail\resgiterOngsMail($request->email, $request->nome_fantasia, $tbl_ongs->id_ongs)); // ATIVAR PARA TESTES
			return response()->json([
				"message" => 'Sua conta foi criado com sucesso por favor verifique o email da ong que está cadastrado no CNPJ',
				"errors" => [],
			]);
		} else {
			return response()->json([
				"message" => 'Não foi possível concluir o cadastro',
				"errors" => [
					"Estamos com algum problema em nosso sistema"
				],
			]);
		}

	}
	
	public function activate($id) 
	{
		$tbl_ongs = $this->ong->select('*')->where('id_ongs','=', $id)->first();

		$tbl_ongs->status = 'true';
		$tbl_ongs->save();

		if($tbl_ongs) {
			return response()->json([
				"message" => "Sua conta foi ativada com sucesso",
				'errors' => []
			]);
		} else {
			return response()->json([
				"message" => 'Não foi possível concluir o cadastro',
				"errors" => [
					"Estamos com algum problema em nosso sistema"
				],
			]);
		}
	}

	public function login(LoginOngRequest $request)
    {
		$credential = $request->only(["email", "password"]);

		$user = $this->ong->select('status')
							->where('email', '=', $request->email)
							->where('status', '=', 'true')
							->first();

		if(!$user) {
			return response()->json([
				'message' => 'Essa conta não foi ativada ainda',
			], 401);
		}

        if (!$token = auth('ong')->attempt($credential)) {
            return response()->json(
				['errors' => 'Seus dados não foram encontrados em nosso sistema'], 401);
		}

		$log = new LogTokenJwt();

		$log->create([
			'token' => $token,
			'email' => $credential['email'],
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

		$teste = $user->select('id_causas_sociais',
								'cnpj',
								'nome_fantasia',
								'razao_social',
								'email',
								'descricao_ong')->first();

        return response()->json($teste);
    }
	
	
	public function index() 
	{
		$listOngs = DB::table('tbl_ongs')
						->join('tbl_causas_sociais', 'tbl_ongs.id_causas_sociais', '=', 'tbl_causas_sociais.id_causas_sociais')
						->join('tbl_enderecos', 'tbl_enderecos.id_ongs', '=', 'tbl_ongs.id_ongs')
						//->where('tbl_ongs.status', '=', 'true')
				        ->select(
								'tbl_ongs.id_ongs as Numero_de_Registro',
    							'tbl_causas_sociais.nome_causa_social as Causa_Social',
    							'tbl_ongs.cnpj as CNPJ',
    							'tbl_ongs.nome_fantasia as Nome_Fantasia',
    							'tbl_ongs.email as E-mail',
    							'tbl_ongs.descricao_ong as Descricao',
    							'tbl_enderecos.rua as Rua',
    							'tbl_enderecos.cep as CEP',
    							'tbl_enderecos.numero as Numero',
    							'tbl_enderecos.complemento as Complemento',
    							'tbl_enderecos.bairro as Bairro',
    							'tbl_enderecos.cidade as Cidade',
    							'tbl_enderecos.uf as Unidade_Federativa'
						)->paginate(1);

		dd(response()->json($listOngs->all()));

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