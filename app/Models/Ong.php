<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ong extends Model
{
    use HasFactory;

    protected $table = 'tbl_ongs';
    protected $primaryKey = 'id_ongs';
    
    protected $fillable = [ 
        'id_causas_sociais', 
        'cnpj',
        'nome_fantasia',
        'razao_social', 
        'email', 
        'senha', 
        'descricao_ong', 
        'img_perfil'
    ];

    protected $guarded = [ 
        'id_ongs',
        'status',
        'created_at',
        'updated_at' 
    ];

    public function causaSocial() 
    {
        return $this->belongsTo(CausaSocial::class, /* fk */'id_causa_social', /* pk */ 'id_causa_social');
    }

    public function ongFavorita() 
    {
        return $this->hasMany(OngFavorita::class, 'id_ongs', 'id_ongs');
    }

    public function listaPedidoOng()
    {
        return $this->hasMany(ListaPedidoOng::class, 'id_ongs', 'id_ongs');
    }

    public function endereco() 
    {
        return $this->hasMany(Enderecos::class. 'id_ongs', 'id_ongs');
    }

    public function relacaoReport()
    {
        return $this->hasMany(RelacaoReport::class, 'id_ongs', 'id_ongs');
    }

    public function relacaoTelefone()
    {
        return $this->hasMany(relacaoTelefone::class, 'id_ongs', 'id_ongs');
    }


}
