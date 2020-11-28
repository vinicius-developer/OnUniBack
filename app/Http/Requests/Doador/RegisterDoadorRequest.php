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
            'email' => 'required|max:80|email:rfc,dns|unique:tbl_doadores',
            'cpf' => 'required|formato_cpf|cpf',
            'password' => 'required|confirmed',
            'genero' => "required|integer",
            'telefones' => "required"
        ];
    }

    public function messages() 
    {
        return [
            'nome.required' => 'O campo nome é necessário ser preenchido',
            'nome.max' => 'Seu nome é muito longo para nossa base de dados',
            'sobrenome.required' => 'O campo sobrenome é necessário',
            'sobrenome.max' => 'Seu sobrenome é muito longo para nossa base dados',
            'email.required' => 'O campo e-mail é necessário ser preenchido',
            'email.max' => 'O campo e-mail é muito longo para nossa base de dados',
            'email.email' => 'O campo e-mail não é valido',
            'email.unique' => 'Esse e-email já está cadastrado em nossa base de dados',
            'cpf.required' => 'O campo cpf é necessário ser preenchido',
            'cpf.formato_cpf' => 'O campo cpf não possui formato válido',
            'cpf.cpf' => 'O campo cpf não é válido',
            'password.required' => 'O campo senha é necessário ser preenchido',
            'password.confirmed' => 'Os campos de senha não são iguais',
            'genero.required' => 'É necessário preencher o campos gênero',
            'genero.integer' => 'O campo gênero precisa ser um inteiro',
            'telefones.required' => 'Pelo menos um telefore precisa ser preenchido'
        ];
    }
}
