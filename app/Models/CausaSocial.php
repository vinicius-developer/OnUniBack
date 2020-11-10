<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CausaSocial extends Model
{
    use HasFactory;

    protected $table = 'tbl_causas_sociais';
    protected $primaryKey = 'id_causas_sociais';

    protected $fillable = ['nome_causa_social'];

    protected $guarded = [
        'id_causas_sociais',
        'created_at',
        'updated_at'
    ];

        public function ong() 
    {
        return $this->hasMany(Ongs::class, 'id_causa_social', 'id_causa_social');
    }
    

}
