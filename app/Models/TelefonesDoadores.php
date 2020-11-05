<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonesDoadores extends Model
{
    use HasFactory;

    protected $table = 'tbl_telefones_doadores';
    protected $primaryKey = 'fk_id_doadores';
}
