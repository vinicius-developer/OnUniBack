<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOngRequest extends FormRequest
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
            'causa_social' => 'required|integer',
            'cnpj' => 'required|cnpj|unique:tbl_ongs',
            'nome_fantasia' => 'required|max:80',
            'razao_social' => 'required|max:80',
            'email' => 'required|max:80|confirmed|email:rfc,dns|unique:tbl_ongs',
            'password' => 'required|confirmed',
            'descricao' => 'required|max:65535',
            'rua' => 'required|max:40',
            'cep' => 'required|formato_cep',
            'numero' => 'required|integer',
            'complemento' => 'max:25',
            'cidade' => 'required|max:40',
            'bairro' => 'required|max:40',
            'uf' => 'required|max:2|min:2',
            'telefones' => 'required'
        ];
    }

    public function messages() {
        return [
            'cnpj.cnpj' => 'O campo CNPJ é inválido',
            'cep.formato_cep' => 'O campo CEP é inválido',
            'email.unique' => 'Esse e-mail já foi cadastrado em nosso sistema',
            'cnpj.unique' => [
                "comment" => 'O CNPJ da sua ong já está cadastrado em nosso sitema, caso necessário entre em contato conosco',
                "contact" => 'onuniContato@gmail.com'
            ]
        ];
    }
}
