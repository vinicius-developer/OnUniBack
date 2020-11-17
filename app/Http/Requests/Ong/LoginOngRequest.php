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
            'cnpj' => 'required|max:80|formato_cnpj',
            'password' => 'required'
        ];
    }
}

