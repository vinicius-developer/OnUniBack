<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportOngDoador extends Model
{
    use HasFactory;

    protected $table = 'tbl_report_ong_doador';
    protected $primaryKey = ['fk_id_doadores', 'fk_id_ongs'];
}
