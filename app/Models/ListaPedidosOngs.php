<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPedidosOngs extends Model
{
    use HasFactory;

    protected $table = 'tbl_listas_pedidos_ongs';
    protected $primaryKey = 'id_item';
}
