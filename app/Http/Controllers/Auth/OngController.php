<?php

namespace App\Http\Controllers\Auth;

use App\Models\On;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Tools\Validators;

class OngController extends Controller
{
	private $validators;
	
	public function __construct() {
		$this->validators = new Validators(); 
 	}

	public function register(Request $request)
	{ 
		$teste = $this->validators->validatorCnpj($request->CNPJ);


		return $teste;
		
	}
}
