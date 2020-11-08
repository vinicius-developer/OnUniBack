<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoEndereco extends Model
{
    use HasFactory;

    protected $table = 'tbl_relacao_enderecos';
    protected $primaryKey = 'id_relacao_enderecos';

    protected $fillable = [
        'id_enderecos', 
        'id_ongs'
    ];

    protected $guarded = [
        'id_relacao_enderecos'
    ];

    public function ong() 
    {
        return $this->belongsTo(Ong::class, 'id_ongs', 'id_ongs');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'id_enderecos', 'id_enderecos');
    }


}
