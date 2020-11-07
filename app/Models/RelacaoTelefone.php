<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoTelefone extends Model
{
    use HasFactory;

    protected $table = 'tbl_relacao_telefones';
    protected $primaryKey = 'id_relacao_telefones';
}
