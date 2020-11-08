<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'tbl_enderecos';
    protected $primaryKey = 'id_enderecos';

    protected $fillable = [
        'rua',
        'numero',
        'complemento',
        'cidade',
        'bairro',
        'uf'
    ];

    protected $guarded = [
        'id_enderecos',
        'created_at',
        'updated_at'
    ];

    public function relacaoEndereco() 
    {
        return $this->hasOne(RelacaoEndereco::class, 'id_doadores', 'id_doadores');
    }

}
