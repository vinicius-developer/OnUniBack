<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = "tbl_enderecos";
    protected $primarykey = 'id_enderecos';

    protected $fillable = [
        'id_ongs',
        'rua',
        'cep',
        'numero',
        'bairro',
        'cidade',
        'complemento',
        'uf'
    ];

    protected $guarded = [
        'id_enderecos',
        'updated_at',
        'created_at'
    ];

    public function ong() {
        return $this->belongsTo(Ong::class, 'id_ongs', 'id_ongs');
    }
}
