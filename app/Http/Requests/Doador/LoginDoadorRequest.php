<?php

namespace App\Http\Requests\Doador;

use Illuminate\Foundation\Http\FormRequest;

class LoginDoadorRequest extends FormRequest
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
            "userkey" => "required|cpf|formato_cpf",
            "password" => "required"
        ];
    }

    public function messages() {
        return [
            'userkey.required' => 'O campo CPF precisa ser preenchido',
            'userkey.cpf' => "CPF não é válido",
            'userkey.formato_cpf' => "O formato do CPF não é válido",
            'passoword.required' => "O campo password precisa ser preenchido",
        ];
    }
}
