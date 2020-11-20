<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{
    public function index($id_ongs) 
    {
        $address = DB::table('tbl_enderecos')
                       ->where('id_ongs', '=', $id_ongs)
                       ->join('tbl_uf', 'tbl_uf.id_uf', '=', 'tbl_enderecos.id_uf')
                       ->select(
                            'tbl_enderecos.rua as Rua',
    						'tbl_enderecos.cep as CEP',
    						'tbl_enderecos.numero as Numero',
    						'tbl_enderecos.complemento as Complemento',
   							'tbl_enderecos.bairro as Bairro',
    						'tbl_enderecos.cidade as Cidade',
    					    'tbl_uf.uf as Unidade Federativa'
                       )->get();

        return response()->json($address);
    }
}
