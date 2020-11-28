<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OngFavorita;
use App\Models\Ong;
use App\Http\Controllers\Controller;


class OngFavoritaController extends Controller
{

    protected $ongs_favoritas;

    public function __construct() 
    {
        $this->ongs_favoritas = new OngFavorita();
    }

    public function switch($id)
    {
        $users = $this->identify($id);      

        if(!empty($users['error'])) return $users;

        $followFind = $this->followFind($users);

        !$followFind ? $response = $this->register($users[0], $users[1]) : $response = $this->delete($users[0], $users[1]);

        return response()->json(['exists' => $response], 200);
    }

    public function index() 
    { 
        $user = Auth::guard('doador')->user();

        $query = $this->ongs_favoritas
                    ->where('id_doadores', '=', $user->id_doadores)
                    ->join('tbl_ongs', 'tbl_ongs_favoritas.id_ongs', '=', 'tbl_ongs.id_ongs')
                    ->select(
                        'tbl_ongs.id_ongs',
                        'tbl_ongs.descricao_ong',
                        'tbl_ongs.nome_fantasia',
                        'tbl_ongs.img_perfil'
                    )->paginate(3);

        return response()->json([$query]);
    }

    public function find($id)
    {
        $users = $this->identify($id);

        if(!empty($users['error'])) return response()->json([$users]);

        $followFind = $this->followFind($users);

        return $followFind ? response()->json(['exists' => true], 200) : response()->json(['exists' => false], 200);

    }

    protected function delete($doador, $ong)
    {
        $this->ongs_favoritas
            ->where('id_ongs', '=', $ong->id_ongs)
            ->where('id_doadores', '=', $doador->id_doadores)
            ->delete();
        
        return false;
    }

    protected function register($doador, $ong)
    {
        $this->ongs_favoritas->id_doadores = $doador->id_doadores;
        $this->ongs_favoritas->id_ongs = $ong->id_ongs; 
        $this->ongs_favoritas->save();

        return true ;
    }

    protected function identify($id) 
    {
        $tbl_ongs = new Ong();

        $doador = Auth::guard('doador')->user();
        $ong = $tbl_ongs->where('id_ongs', '=', $id)->first();

        if(!$ong) {
            return [
                'message' => 'Informação inexistente',
                'error' => [
                    'Ong não está registrada em nossa base de dados'
                ]];
        } else {
            return [$doador, $ong];
        }

    }

    protected function followFind($users) 
    {
        return $this->ongs_favoritas
                   ->where('id_doadores', '=', $users[0]->id_doadores)
                   ->where('id_ongs', '=', $users[1]->id_ongs)
                   ->exists();
    }

}
