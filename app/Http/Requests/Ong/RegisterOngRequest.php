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
            'cnpj' => 'required|formato_cnpj|unique:tbl_ongs|cnpj',
            'nome_fantasia' => 'required|max:80',
            'razao_social' => 'required|max:80',
            'email' => 'required|max:80|email:rfc,dns|unique:tbl_ongs',
            'password' => 'required|confirmed',
            'descricao' => 'required|max:65535',
            'rua' => 'required|max:40',
            'cep' => 'required|formato_cep',
            'numero' => 'required|integer',
            'complemento' => 'max:25',
            'cidade' => 'required|max:40',
            'bairro' => 'required|max:40',
            'uf' => 'required|integer',
            'telefones' => 'required'
        ];
    }

    public function messages() {
        return [
            'causa_socail.required' => 'necessário ser preenchido',
            'cnpj.required' => 'necessário ser preenchido',
            'nome_fantasia.required' => 'necessário ser preenchido',
            'razao_social.required' => 'necessário ser preenchido',
            'email.required' => 'necessário ser preenchido',
            'password.required' => 'necessário ser preenchido',
            'descricao.required' => 'necessário ser preenchido',
            'rua.required' => 'necessário ser preenchido',
            'cep.required' => 'necessário ser preenchido',
            'numero.required' => 'necessário ser preenchido',
            'complemento.required' => 'necessário ser preenchido',
            'cidade.required' => 'necessário ser preenchido',
            'bairro.required' => 'necessário ser preenchido',
            'uf.required' => 'necessário ser preenchido',
            'talefones.required' => 'necessário ser preenchido',
            'cnpj.cnpj' => 'é inválido',
            'cep.formato_cep' => 'é inválido',
            'email.unique' => 'já foi cadastrado em nosso sistema',
            'cnpj.unique' => [
                "comment" => 'da sua ong já está cadastrado em nosso sitema, caso necessário entre em contato conosco',
                "contact" => 'onuniContato@gmail.com'
            ]
        ];
    }
}
