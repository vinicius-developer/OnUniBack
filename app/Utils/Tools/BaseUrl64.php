<?php

namespace App\Utils\Tools;


class BaseUrl64 
{

    public function encode(string $hash):string
    {
        return str_replace('=', '', strtr(base64_encode($hash), '+/', '-_'));
    }

    protected function decode($hash) 
    {
        $b64 = strtr($hash, '-_', '+/');

        return base64_decode($b64, $strict);
    }

}