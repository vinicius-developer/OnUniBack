<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonesOngs extends Model
{
    use HasFactory;

    protected $table = 'tbl_telefones_ongs';
    protected $primaryKey = 'fk_id_ongs';
}
