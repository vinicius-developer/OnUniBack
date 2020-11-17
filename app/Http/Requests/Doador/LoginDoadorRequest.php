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
            "cpf" => "required|formato_cpf",
            "password" => "required"
        ];
    }
}
