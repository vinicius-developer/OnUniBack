<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoEnderecos extends Model
{
    use HasFactory;

    protected $table = 'tbl_relacao_enderecos';
    protected $primaryKey = 'id_relacao_enderecos';
}
