<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
    use HasFactory;

    protected $table = 'tbl_lojas';
    protected $primaryKey = 'id_lojas';

    protected $filllable = [
        'nome_loja',
        'link_loja'
    ];

    protected $guarded = [
        'id_lojas',
        'updated_at',
        'created_at'
    ];

    public function listaPedidoOng() {
        return $this->hasMany(ListaPedidoOng::class, 'id_lojas', 'id_lojas');
    }
}
