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

    public function messages() 
    {
        return [
            'causa_social.required' => 'A Causa Social deve ser preenchida',
            'causa_social.integer' => 'O campo causa Social deve ser um número',
            'cnpj.required' => 'O campo CNPJ deve ser preenchido',
            'cnpj.formato_cnpj' => 'O CNPJ não tem formato válido',
            'cnpj.unique' => 'O CNPJ já está cadastrado em nosso sistema entre em contato conosco, e-mail: onunicontato@gmail.com',
            'cnpj.cnpj' => 'CNPJ não é válido',
            'nome_fantasia.required' => 'O nome fantasia deve ser preenchido',
            'nome_fantasia.max' => 'O nome fantasia é muito longo',
            'razao_social.required' => 'A razão social precisa ser preenchida',
            'razao_social.max' => 'A razão social é muito longo',
            'email.required' => 'O campo e-mail deve ser preenchido',
            'email.email' => 'O e-mail não tem formato válido',
            'email.unique' => 'O e-mail já está cadastrado em nosso sistema entre em contato conosco, e-mail: onunicontato@gmail.com',
            'email.max' => 'O e-mail é muito longo',
            'password.required' => 'O campo senha precisa ser preenchido',
            'password.confirmed' => 'Os campos de senha devem ser preenchidas',
            'descricao.required' => 'O campo descrição precisa ser preenchido',
            'descricao.max' => 'Sua descrição é muito longa',
            'rua.required' => 'O campo rua precisa ser preenchido',
            'rua.max' => 'O campo rua é muito longo',
            'cep.required' => 'O campo CEP precisa ser preenchido',
            'cep.formato_cep' => 'O campo CEP nãp tem formato válido',
            'numero.required' => 'O campo numero precisa ser preenchido',
            'numero.integer' => 'O campo numero precisa ser um inteiro',
            'complemento.max' => 'O campo complemento é muito longo',
            'cidade.required' => 'O campo cidade precisa ser preenchido',
            'cidade.max' => 'O campo cidade é muito longo',
            'bairro.required' => 'O campo bairro precisa ser preenchido',
            'bairro.max' => 'O campo bairro é muito longo',
            'uf.required' => 'O campo UF precisa ser preenchido',
            'uf.integer' => 'O campo UF precisa ser inteiro',
            'telefones.required' => 'O campo telefone precisa ser preenchido'
        ];
    }
}
