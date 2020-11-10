<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPedidoOng extends Model
{
    use HasFactory;

    protected $table = 'tbl_listas_pedidos_ongs';
    protected $primaryKey = 'id_listas_pedidos_ongs';

    protected $fillable = [
        'id_ongs',
        'nome_item',
    ];

    protected $guarded = [
        'id_listas_pedidos_ongs',
        'updated_at',
        'created_at'
    ];

    public function ong() 
    {
        return $this->belongsTo(Ong::class, 'id_ongs', 'id_ongs');
    }

    public function loja() 
    {
        return $this->belongsTo(ListaPedidosOng::class, 'id_ongs', 'id_ongs');
    }

}
