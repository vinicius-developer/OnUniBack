<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngFavorita extends Model
{
    use HasFactory;

    protected $table = 'tbl_ongs_favoritas';
    protected $primaryKey = 'id_ongs_favoritas';
}
