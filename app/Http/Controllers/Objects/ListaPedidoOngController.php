<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListaPedidosOng\RegisterListaPedidosOngRequest;
use App\Models\ListaPedidoOng;
use App\Models\Ong;
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

    public function index($id) 
    {
        $user = $this->ongExists($id);

        if(!$user) {
            return response()->json([
                'message' => 'Erro na busca em nosso base de dados',
                'erros' => [
                    'A ong inserida não existe em nossa base de dados'
                ]], 400);
        } 

        $items = $this->lista_pedidos_ongs
                        ->select(
                            'tbl_listas_pedidos_ongs.id_listas_pedidos_ongs as idListaPedidos',
                            'tbl_listas_pedidos_ongs.nome_item as nomeItem',
                            'tbl_lojas.nome_fantasia_loja as nomeFantasiaLoja',
                            'tbl_lojas.link_loja as linkLoja'
                        )
                        ->join('tbl_ongs', 'tbl_ongs.id_ongs', '=', 'tbl_listas_pedidos_ongs.id_ongs')
                        ->join('tbl_lojas', 'tbl_lojas.id_lojas', '=', 'tbl_listas_pedidos_ongs.id_lojas')
                        ->where('tbl_listas_pedidos_ongs.id_ongs', '=', $id)
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
                "message" => "Você precisa ser uma ong para alterar a lista de desejos",
            ];
        }

        return $user;
    }

    protected function ongExists($id) 
    {
        $ong = new Ong();

        $user = $ong->where('id_ongs', '=', $id)->exists();

        return $user;
    }
}
