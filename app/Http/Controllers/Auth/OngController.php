<?php

namespace App\Http\Controllers\Auth;

use App\Models\Ong;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Http\Request\RegisterOngRequest;
use App\Utils\Tools\Validators;
use App\Utils\Api\ReceitaWs;
use App\Email\registerOngEmail;
use Mail;

class OngController extends Controller
{
	private $validators;
	private $receitaWs;
	private $ong;
	
	public function __construct() 
	{
		$this->validators = new Validators(); 
		$this->receitaWs = new ReceitaWS();
		$this->ong = new Ong();
 	}

	public function register(Request $request)
	{
		$validRequest = $request->validate([
			'id_causas_requires' => 'required',
            'cnpj' => 'required',
            'nome_fantasia' => 'required',
            'razao_social' => 'required',
            'email' => 'required',
            'senha' => 'required' ,
            'descricao' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'complemento' => 'required',
            'cidade' => 'required',
            'bairro' => 'required',
            'uf' => 'required',
            'telefone' => 'required'
		]);

		$cnpjOnlyNumbers = preg_replace('/[^0-9]/', '', (string) $request->cnpj);
		$validatorCnpj = $this->validators->validatorCnpj($cnpjOnlyNumbers);

		$cnpjExists = $this->ong->where('cnpj', $request->cnpj)->exists();

		$emailExists = $this->ong->where('email', $request->email)->exists();


		if(!$validatorCnpj) {
			return response()->json([
				"status" => 'error',
				"message" => "CNPJ inválido",
			]);
		} else if($cnpjExists) {
			return response()->json([
				"status" => "error",
				"message" => "O CNPJ da sua ong já está cadastrado em nosso sitema, por favor entre em contado conosco para resolvermos o problema",
				"contact" => "onuniContato@gmail.com", /* só para teste */
			]);
		} else {
			// $response = $this->receitaWs->requestGetWs($cnpjOnlyNumbers);

			// if($response["situacao"] !== "ATIVA") {
			// 	return response()->json([
			// 		"message" => "Error: CPNJ não está ativo",
			// 		"code" => 0002
			// 	]);
			// }
		}

		if($emailExists)
			return response()->json([
				"status" => "error",
				"message" => "Esse e-mail já foi cadastrado em nosso sistema"
			]);

		$resultCreateRegister = $this->ong->create([
			'id_causas_sociais' => $request->id_causas_sociais,
			'cnpj' => $request->cnpj,
			'nome_fantasia' => $request->nome_fantasia,
			'razao_social' => $request->razao_social,
			'email' => $request->email,
			'senha' => bcrypt($request->senha),
			'descricao_ong' => $request->descricao,
			'img_perfil' => $request->file()['img']->store("pothoPerfilOng"),
		]);

		if($resultCreateRegister) {
			//Mail::send(new \App\Mail\resgiterOngsMail($request->email, $request->nome_fantasia));
			return response()->json([
				"status" => "sucesso",
				"message" => 'Sua conta foi criado com secesso por favor verifique se email',
			]);
		} else {
			return response()->json([
				"status" => "error",
				"message" => 'Não foi possível concluir o cadastro',
			]);
		}

	}
}
