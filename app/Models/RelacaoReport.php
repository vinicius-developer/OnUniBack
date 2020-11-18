<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoReport extends Model
{
    use HasFactory;

    protected $table = 'tbl_relacao_reports';
    protected $primaryKey = 'id_relacao_reports';

    protected $fillable = [
        'id_doadores',
        'id_ongs',
        'id_reports'
    ];

    protected $guarded = [
        'id_relacao_reports'
    ];

    public $timestamps = false;


    public function ong() 
    {
        return $this->belongsTo(Ong::class, 'id_ongs', 'id_ongs');
    }

    public function doador() 
    {
        return $this->belongsTo(Doador::class, 'id_doadores', 'id_doadores');
    }

    public function report() 
    {
        return $this->belongsTo(Report::class, 'id_reports', 'id_reports');
    }
}
