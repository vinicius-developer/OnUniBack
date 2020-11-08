<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngFavorita extends Model
{
    use HasFactory;

    protected $table = 'tbl_ongs_favoritas';
    protected $primaryKey = 'id_ongs_favoritas';

    protected $fillable = [
        'id_ongs',
        'id_doadores',
    ];

    protected $guarded = [
        'id_ongs_favoritas',
        'created_at',
        'updated_at'
    ];

    public function ongs() 
    {
        return $this->belongsTo(Ong::class, /* fk */ 'id_ongs',  /* pk */'id_ongs');
    }    

    public function doadores() 
    {
        return $this->belongsTo(Doador::class, /* fk */ 'id_doadores', /* pk */ 'id_doadores');
    }

}
