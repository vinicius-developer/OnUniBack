<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OngFavorita;
use App\Models\Ong;
use App\Http\Controllers\Controller;
use App\Http\Requests\OngFavorita\RegisterOngFavoritaRequest;


class OngFavoritaController extends Controller
{

    protected $ongs_favoritas;

    public function __construct() 
    {
        $this->ongs_favoritas = new OngFavorita();
    }

    public function switch(RegisterOngFavoritaRequest $request)
    {
        $tbl_ongs = new Ong();

        $doador = Auth::guard('doador')->user();
        $ong = $tbl_ongs->where('id_ongs', '=', $request->id_ongs)->first();

        $followExists = $this->ongs_favoritas
               ->where('id_ongs', '=', $ong->id_ongs)
               ->where('id_doadores', '=', $doador->id_doadores)
               ->exists();

        if(!$followExists) {
            $response = $this->register($doador, $ong);
        } else {
            $response = $this->delete($doador, $ong);
        }

        return $response ? response()->json(["message" => "Salvo!"], 200) : response()->json(["message" => "Erro"],400);
    }

    public function index() 
    { 
        $user = Auth::guard('doador')->user();

        $query = $this->ongs_favoritas
                    ->where('id_doadores', '=', $user->id_doadores)
                    ->join('tbl_ongs', 'tbl_ongs_favoritas.id_ongs', '=', 'tbl_ongs.id_ongs')
                    ->select(
                        'tbl_ongs.id_ongs',
                        'tbl_ongs.email',
                        'tbl_ongs.nome_fantasia',
                        'tbl_ongs.img_perfil'
                    )->paginate(10);

        return response()->json([$query]);
    }

    protected function delete($doador, $ong)
    {
        $followDelete = $this->ongs_favoritas
                            ->where('id_ongs', '=', $ong->id_ongs)
                            ->where('id_doadores', '=', $doador->id_doadores)
                            ->delete();
        
        return $followDelete ? true : false;
    }

    protected function register($doador, $ong)
    {
        $this->ongs_favoritas->id_doadores = $doador->id_doadores;
        $this->ongs_favoritas->id_ongs = $ong->id_ongs; 
        $createRegister = $this->ongs_favoritas->save();

        return $createRegister ? true : false;
    }

}
