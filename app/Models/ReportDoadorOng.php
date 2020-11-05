<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDoadorOng extends Model
{
    use HasFactory;

    protected $table = 'tbl_report_doador_ong';
    protected $primaryKey = ['fk_id_doadores', 'fk_id_ongs'];
}
