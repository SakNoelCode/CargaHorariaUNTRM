<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = ['escuela_id','condicion_id','categoria_id','modalidad_id','user_id'];

    protected $guarded = ['id'];
}
