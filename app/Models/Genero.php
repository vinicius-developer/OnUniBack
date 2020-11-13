<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = "tbl_generos";
    protected $primaryKey = "id_generos";

    protected $fillable = [
        'nome_generos'
    ];

    protected $guarded = [
        'id_generos',
        'created_at',
        'updated_at'
    ];

    public function doador() {
        return $this->hasOne(Doador::class, 'id_doadores', 'id_doadores');
    }
}
