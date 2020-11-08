<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoTelefone extends Model
{
    use HasFactory;

    protected $table = 'tbl_relacao_telefones';
    protected $primaryKey = 'id_relacao_telefones';

    protected $fillable = [
        'id_doadores',
        'id_ongs',
        'id_telefones'
    ];

    protected $guarded = [
        'id_relacao_telefones'
    ];

    public function doador() 
    {
        return $this->belongTo(Doador::class, 'id_doadores', 'id_doadores');
    }

    public function ong() 
    {
        return $this->belongTo(Ong::class, 'id_ongs', 'id_ongs');
    }

    public function telefone() 
    {
        return $this->belongTo(Telefone::class, 'id_telefones', 'id_telefones');
    }



}
