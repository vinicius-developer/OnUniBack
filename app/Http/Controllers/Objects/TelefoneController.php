<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TelefoneController extends Controller
{
    public function index($id_ongs) 
    {
       $telephone = DB::table('tbl_telefones')
                        ->join('tbl_relacao_telefones',
                            'tbl_relacao_telefones.id_telefones', '=' , 'tbl_telefones.id_telefones')
                        ->join('tbl_ongs', 
                            'tbl_ongs.id_ongs', '=', 'tbl_relacao_telefones.id_ongs')
                        ->where('tbl_relacao_telefones.id_ongs', '=', $id_ongs)
                        ->select(
                            'tbl_telefones.numero_telefone as numTel'
                        )->get();

        if(count($telephone) > 0) {
            return response()->json($telephone);
        } else {
            return response()->json([
                'message' => 'Esses dados não foram encontrados',
				'error' => [
					'Não conseguimos encontrar telefones dessa ong em nosso sistema sistema'
			]], 400); 
        }
    }
}
