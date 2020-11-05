<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CausasSociais extends Model
{
    use HasFactory;

    protected $table = 'tbl_causas_sociais';
    protected $primaryKey = 'id_causa_social';
}
