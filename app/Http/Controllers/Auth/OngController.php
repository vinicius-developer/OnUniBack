<?php

namespace App\Http\Controllers\Auth;

use App\Models\On;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Tools\Validators;
use App\Utils\Api\ReceitaWs;
use Mail;

class OngController extends Controller
{
	private $validators;
	private $receitaWs;
	
	public function __construct() 
	{
		$this->validators = new Validators(); 
		$this->receitaWs = new ReceitaWS();
 	}

	public function register(Request $request)
	{ 

		$ongEmail = $request->email;
		$nomeFantasia = $request->nome_fantasia;
		$cnpjOnlyNumbers = preg_replace('/[^0-9]/', '', (string) $request->CNPJ);

		/* validação sintaxe cnpj */

		$validatorCnpj = $this->validators->validatorCnpj($cnpjOnlyNumbers);

		if($validatorCnpj === false) {
			return response()->json([
				"status" => "Error: CNPJ inválido",
				"code" => 0001
			]);
		
		} else {
			/* validação existencia cnpj */

			// $response = $this->receitaWs->requestGetWs($cnpjOnlyNumbers);

			// if($response["situacao"] !== "ATIVA") {
			// 	return response()->json([
			// 		"status" => "Error: CPNJ não está ativo",
			// 		"code" => 0002
			// 	]);
			// }
		}

		return new \App\Mail\resgiterOngsMail($ongEmail, $nomeFantasia);

		// Mail::send(new \App\Mail\resgiterOngsMail($ongEmail, $nomeFantasia));

	}
}
