<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doadores extends Model
{
    use HasFactory;

    protected $table = 'tbl_doadores';
    protected $primaryKey = 'id_doadores';
}
