<?php 

namespace App\Utils\Tools;

class GenerateJWT 
{
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

        $jwt = $hashHeader. '.' .$hashPayload. '.' .$hashSignature;

        return $jwt;
    }

    protected function hashObjects($infos)
    {
        $hash = json_encode($infos);
        $hash = $this->baseurl64_encode($hash);

        return $hash;
    }

    protected function shaSignature($header, $payload, $signature) 
    {
        $sha = hash_hmac('sha256', $header.$payload, $signature, true);
        $result = $this->baseurl64_encode($sha);

        return $result;
    }

    protected function baseurl64_encode($hash) 
    {
        $url = base64_encode($hash);

        $url = strtr($url, '/+', '-');

        return rtrim($url, '=');
    }

    protected function baseurl64_decode($hash) 
    {
        $b64 = strtr($hash, '-_', '+/');

        return base64_decode($b64, $strict);
    }

}