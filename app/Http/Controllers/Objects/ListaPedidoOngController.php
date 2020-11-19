<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListaPedidosOng\RegisterListaPedidosOngRequest;
use App\Models\ListaPedidoOng;
use Illuminate\Support\Facades\Auth;

class ListaPedidoOngController extends Controller
{

    protected $lista_pedidos_ongs;

    public function __construct() 
    {
        $this->lista_pedidos_ongs = new ListaPedidoOng();
    }

    public function register(RegisterListaPedidosOngRequest $request) 
    {
        $user = $this->checkOng();

        if(isset($user['message'])) return response()->json($user, 401);

        $this->lista_pedidos_ongs->id_ongs = $user->id_ongs;
        $this->lista_pedidos_ongs->nome_item = $request->nome_item;
        $this->lista_pedidos_ongs->id_lojas = $request->id_lojas;
        $createItem = $this->lista_pedidos_ongs->save();

        if($createItem) {
            return response()->json([
                "message" => "Seu item foi criado com sucesso"
            ], 200);
        } else {
            return response()->json([
                "message" => "Estamos com preblemas em nosso sitema"
            ], 404);
        }
    }

    public function index() {
        $user = $this->checkOng();

        if(isset($user['message'])) return response()->json($user, 401);

        $items = $this->lista_pedidos_ongs
                        ->select(
                            'tbl_listas_pedidos_ongs.id_listas_pedidos_ongs',
                            'tbl_listas_pedidos_ongs.nome_item',
                            'tbl_listas_pedidos_ongs.id_lojas'
                        )
                        ->join('tbl_ongs', 'tbl_ongs.id_ongs', '=', 'tbl_listas_pedidos_ongs.id_ongs')
                        ->where('tbl_listas_pedidos_ongs.id_ongs', '=', $user->id_ongs)
                        ->paginate(5);
        if($items) {
            return response()->json($items, 200);
        } else {
            return response()->json([
                "message" => "Estamos com preblemas em nosso sitema"
            ], 404);
        }
    }

    public function delete($id) {
        $user = $this->checkOng();

        if(isset($user['message'])) return response()->json($user, 401);

        $teste  = $this->lista_pedidos_ongs
                        ->where('id_listas_pedidos_ongs', '=', $id)
                        ->delete();

        if($teste) {
            return reponse()->json([
                "message" => "Esse item foi deletado com sucesso"
            ], 200);
        } else {
            return response()->json([
                "message" => "Este item já foi deletado"
            ], 404);
        }
    }

    protected function checkOng() {
        $user = Auth::guard('ong')->user();

        if(!isset($user->id_ongs)) {
            return [
                "message" => "Você precisa ser uma ong para cadastrar um item na sua lista de desejos",
            ];
        }

        return $user;
    }
}
