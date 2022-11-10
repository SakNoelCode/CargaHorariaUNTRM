<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaLectiva extends Model
{
    use HasFactory;

    protected $table = 'carga_lectivas';

    protected $fillable = ['declaracionJurada_id'];

    protected $guarded = ['id'];
}
