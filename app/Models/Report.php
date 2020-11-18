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
        'explicacao',
        'tipo_usuario_reportado',
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
