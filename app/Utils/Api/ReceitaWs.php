<?php 

namespace App\Utils\Api;

use Illuminate\Support\Facades\Http;

class ReceitaWs {

    public function requestGetWs($cnpj) {

		$cnpjOnlyNumbers = preg_replace('/[^0-9]/', '', (string) $cnpj);

        $reponse = Http::get('https://www.receitaws.com.br/v1/cnpj/'. $cnpjOnlyNumbers);

        return $reponse->json();

    }
}