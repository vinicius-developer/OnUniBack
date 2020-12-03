<?php

namespace App\Http\Controllers\Objects;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class TelefoneController extends Controller
{
    public function indexDoa($id_ongs) 
    {
       $telephones = $this->queryIndexTelephone($id_ongs);

       if(count($telephones) > 0) {
            return response()->json($telephones);
        } else {
            return response()->json([
                'message' => 'Esses dados não foram encontrados',
				'error' => [
					'Não conseguimos encontrar telefones dessa ong em nosso sistema sistema'
			]], 400); 
        }
    }

    public function indexOng() 
    {
        $ong = Auth::guard('ong')->user();

        $telephones = $this->queryIndexTelephone($ong->id_ongs);


       if(count($telephones) > 0) {
            return response()->json($telephones);
        } else {
            return response()->json([
                'message' => 'Esses dados não foram encontrados',
				'error' => [
					'Não conseguimos encontrar telefones dessa ong em nosso sistema sistema'
			]], 400); 
        }
    }

    protected function queryIndexTelephone($id) 
    {
        return DB::table('tbl_telefones')
                    ->join('tbl_relacao_telefones',
                        'tbl_relacao_telefones.id_telefones', '=' , 'tbl_telefones.id_telefones')
                    ->join('tbl_ongs', 
                        'tbl_ongs.id_ongs', '=', 'tbl_relacao_telefones.id_ongs')
                    ->where('tbl_relacao_telefones.id_ongs', '=', $id)
                    ->select(
                        'tbl_telefones.numero_telefone as numTel'
                    )->get();
    }
}
