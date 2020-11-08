<?php

namespace App\Http\Requests;

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
            'id_causas_requires' => 'required | numeric',
            'cnpj' => 'required | max:18',
            'nome_fantasia' => 'required | max:80',
            'razao_social' => 'required | max:80',
            'email' => 'required | max:80',
            'senha' => 'required' ,
            'descricao' => 'required | max:65.535',
            'rua' => 'required | max:40',
            'numero' => 'required | numeric',
            'complemento' => 'required | max:25',
            'cidade' => 'required | max:40',
            'bairro' => 'required | max:40',
            'uf' => 'required | max:2 | min:2',
            'telefone' => 'required'
        ];
    }
}
