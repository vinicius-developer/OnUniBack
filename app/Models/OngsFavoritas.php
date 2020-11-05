<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngsFavoritas extends Model
{
    use HasFactory;

    protected $table = 'tbl_ongs_favoritas';
    protected $primaryKey = ['fk_id_doador', 'dk_id_ong'];
}
