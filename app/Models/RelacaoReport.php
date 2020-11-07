<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoReport extends Model
{
    use HasFactory;

    protected $table = 'tbl_relacao_reports';
    protected $primaryKey = 'id_relacao_reports';
}
