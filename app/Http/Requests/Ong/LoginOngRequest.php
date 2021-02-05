<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class LoginOngRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userkey' => 'required|cnpj|formato_cnpj',
            'password' => 'required'
        ];
    }

    public function messages() 
    {
        return [
            'userkey.required' => 'O campo CNPJ precisa ser preenchido',
            'userkey.cnpj' => "CNPJ não é válido",
            'userkey.formato_cnpj' => "O formato do CNPJ não é válido",
            'password.required' => "O campo senha precisa ser preenchido",
        ];
    }
}

