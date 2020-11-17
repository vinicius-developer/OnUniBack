<?php

namespace App\Http\Requests\Doador;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDoadorRequest extends FormRequest
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
            'nome' => 'required|max:30',
            'sobrenome' => 'required|max:50',
            'email' => 'required|max:80|email|confirmed|email:rfc,dns|unique:tbl_doadores',
            'cpf' => 'required|min:14|max:14|formato_cpf',
            'password' => 'required|confirmed',
            'genero' => "required|integer"
        ];
    }

    public function messages() {
        return [
            'cpf.formato_cpf' => 'O campo CPF é inválido',
        ];
    }
}
