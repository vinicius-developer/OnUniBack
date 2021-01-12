<?php 

namespace App\Utils\Tools;

class Validators 
{
    public function validatorPassword($password) 
    {
        /* Mínimo de oito caracteres, pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial */
        $validatorPassword = preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password);
        

		if(!$validatorPassword) {
			return [
				"message" => "The given data was invalid",
				"errors" => [
					"password" => [
						"A senha deve conter no mínimo oito caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial"
					]
				]
			];
        }

        return;
    }
}