<?php 

namespace App\Utils\Tools;

class GenerateJWT 
{
    protected $baseUrl64;

    public function __construct() 
    {
        $this->baseUrl64 = new BaseUrl64;
    }

    public function resultKey($header, $payload, $signature) 
    {
        if(!is_array($header) || !is_array($payload) || !is_string($signature)) {
            return response()->json([
                "message" => 'os dois primeiros parâmetros precisam ser objetos e o ultimo uma string'
            ]);
        }

        $hashHeader = $this->hashObjects($header);
        $hashPayload = $this->hashObjects($payload);
        $hashSignature = $this->shaSignature($hashHeader, $hashPayload, $signature);

        $jwt = $hashHeader . '.' . $hashPayload. '.' . $hashSignature;

        return $jwt;
    }

    protected function hashObjects($infos)
    {
        $hash = json_encode($infos);
        $hash = $this->baseUrl64->encode($hash);

        return $hash;
    }

    protected function shaSignature($header, $payload, $signature) 
    {
        $sha = hash_hmac('sha256', $header.$payload, $signature, true);
        $result = $this->baseUrl64->encode($sha);

        return $result;
    }
}