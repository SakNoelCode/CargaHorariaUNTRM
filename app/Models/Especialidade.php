<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;

    public function docentes(){
        return $this->belongsToMany(Docente::class)->withTimestamps();
    }

    public function cursos(){
        return $this->hasMany(Curso::class);
    }
}
