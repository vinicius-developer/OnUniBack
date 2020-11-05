<?php 

namespace App\Utils\Api;

use Illuminate\Support\Facades\Http;

class ReceitaWs {

    public function requestGetWs($cnpj) {


        $reponse = Http::get('https://www.receitaws.com.br/v1/cnpj/'. $cnpj);

        return $reponse->json();

    }
}