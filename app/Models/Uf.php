<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    use HasFactory;

    public $table = "tbl_uf";
    public $primaryKey = "id_uf";
    public $timestamps = false;

    protected $fillabel = [
        'uf'
    ];

    protected $guarded = [
        'id_uf'
    ];

    public function enderecos()
    {
        return $this->hasOne(Endereco::class, 'id_uf', 'id_uf');
    }
}
