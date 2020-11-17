<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;


class Doador extends Authenticatable implements JWTSubject 
{
    use Notifiable;

    protected $table = 'tbl_doadores';
    protected $primaryKey = 'id_doadores';

    protected $fillable = [
        'nome', 
        'sobrenome', 
        'email', 
        'password', 
        'img_perfil'
    ];

    protected $guarded = [
        'id_doadores',
        'status',
        'created_at',
        'updated_at'
    ];

    public $incrementing = false;
    public $keyType = 'string';


    public function ongFavorita() 
    {
        return $this->hasMany(OngFavorita::class, 'id_doadores', 'id_doadores');
    }

    public function relacaoReport()
    {
        return $this->hasMany(RelacaoReport::class, 'id_doadores', 'id_doadores');
    }

    public function relacaoTelefone()
    {
        return $this->hasMany(RelacaoTelefone::class, 'id_doadores', 'id_doadores');
    }

    public function genero() 
    {
        return $this->belongsTo(Genero::class, 'id_genero', 'id_genero');
    }

    public function getJWTIdentifier() 
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
