<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Endereco;

class EnderecoController extends Controller
{
    protected $tbl_enderecos;

    public function __construct() 
    {
        $this->tbl_enderecos = new Endereco;
    }

    public function indexDoa($id_ongs) 
    {
        $userExists = $this->userExists($id_ongs);

        if(!$userExists) {
             return response()->json([
                'message' => 'Esses dados não foram encontrados',
				'error' => [
					'Não conseguimos encontrar o endereço dessa ong'
			]], 400);
        }

        $address = $this->queryIndexTelephone($id_ongs);

        return response()->json($address);
    }

    public function indexOng() 
    {
        $ong = Auth::guard('ong')->user();

        if(!$ong) {
            return response()->json([
                'message' => 'Esses dados não foram encontrados',
				'error' => [
					'Não conseguimos encontrar o endereço dessa ong'
			]], 400); 
        }

        $address = $this->queryIndexTelephone($ong->id_ongs);

        return response()->json($address);
    }

    protected function queryIndexTelephone($id) 
    {
        return $this->tbl_enderecos
                    ->where('id_ongs', '=', $id)
                    ->join('tbl_uf', 'tbl_uf.id_uf', '=', 'tbl_enderecos.id_uf')
                    ->select(
                        'tbl_enderecos.rua as Rua',
    		    		'tbl_enderecos.cep as CEP',
    					'tbl_enderecos.numero as Numero',
    					'tbl_enderecos.complemento as Complemento',
   						'tbl_enderecos.bairro as Bairro',
    					'tbl_enderecos.cidade as Cidade',
    				    'tbl_uf.uf as UF'
                    )->get();
    }

    protected function userExists($id) 
    {
        $user = $this->tbl_enderecos->where('id_ongs', '=', $id)->exists();

        return $user;
    }

    
}
