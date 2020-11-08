<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    protected $table = 'tbl_telefones';
    protected $primaryKey = 'id_telefones';

    protected $fillable = ['numero_telefone'];

    protected $guarded = [
        'id_telefones',
        'updated_at',
        'created_at'
    ];

    public function relacaoTelefone()
    {
        return $this->hasOne(Telefone::class, 'id_telefones', 'id_telefones');
    }

}
