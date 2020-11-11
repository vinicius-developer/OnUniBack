<?php

namespace App\Http\Controllers\Auth;

use App\Models\Ong;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\RelacaoTelefone;
use App\Http\Requests\Ong\RegisterOngRequest;
use App\Http\Requests\Ong\LoginOngRequest;
use App\Http\Controllers\Controller;
use App\Utils\Api\ReceitaWs;
use App\Utils\Tools\GenerateJWT;
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

		/* Mínimo de oito caracteres, pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial */
		$validatorPassword = preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $request->senha);

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
		$tbl_ongs->senha = bcrypt($request->senha);
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
			Mail::send(new \App\Mail\resgiterOngsMail($request->email, $request->nome_fantasia, $tbl_ongs->id_ongs)); // ATIVAR PARA TESTES
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
				"message" => "Sua conta foi ativada com sucesso tenta entrar",
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

		$user = $this->ong->select('*')->where('email', '=', $request->email)->first();

		if(!$user || crypt($request->senha, $user->senha) !== $user->senha) {
			return response()->json([
				"message" => 'As informações inseridas estão incorretas ou não estão cadastrados em nosso sitema',
				"errors" => [
					"Unauthorized" => 401
				]
			]);
		}



		$jwt = new GenerateJWT();
		$header = [
			'typ' => 'jwt', 
			'alg' => 'HS256'
		];
		$payload = [
			'sub' => $user->id_ongs,
			'exp' => intval(date("U")) + 86400,
			'type' => 'ong',
			'email' => $user->email
		];
		$signature = "pao";



		$key = $jwt->resultKey($header, $payload, $signature);

		return $key;
	}
}