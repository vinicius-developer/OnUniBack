<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class InfoOngRequest extends FormRequest
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
            'info' => 'required',
            'att' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'info.required' => 'É necessário inserir novas informações para fazer alteração',
            'att.required' => 'É necessário adicionar o atributo'
        ];
    }
}
