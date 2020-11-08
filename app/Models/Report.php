<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'tbl_reports';
    protected $primaryKey = 'id_reports';

    protected $fillable = [
        'explicaco',
        'tipo_usuario_report',
    ];

    protected $guarded = [
        'id_reports',
        'created_at',
        'updated_at'
    ];

    public function relacaoReport()
    {
        return $this->hasOne(Report::class, 'id_reports', 'id_reports');
    } 
}
