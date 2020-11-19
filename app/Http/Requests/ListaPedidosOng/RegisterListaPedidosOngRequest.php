<?php

namespace App\Http\Requests\ListaPedidosOng;

use Illuminate\Foundation\Http\FormRequest;

class RegisterListaPedidosOngRequest extends FormRequest
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
            "nome_item" => "required|max:40",
            "id_lojas" => "required|integer"
        ];
    }
}
