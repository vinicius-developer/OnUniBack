<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTokenJwt extends Model
{
    use HasFactory;

    protected $table = "tbl_logs_tokens_jwt";
    protected $primaryKey = 'id_logs_tokens_jwt';

    protected $fillabel = [
        'token',
        'email',
        'tipo_usuario'
    ];

    protected $guarded = [
        'id_logs_tokens_jwt',
        'created_at',
        'updated_at'
    ];
}
