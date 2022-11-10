<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionJurada extends Model
{
    use HasFactory;

    protected $table = 'declaracion_juradas';

    protected $fillable = ['estado','documento','periodo_id','docente_id'];

    protected $guarded = ['id'];
}
