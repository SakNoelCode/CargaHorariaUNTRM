<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = ['nombre','tipo'];

    protected $guarded = ['id'];

    /**
     * Relacion n:n con el modelo CargaLectiva
     */
    public function cargaLectiva(){
        return $this->belongsToMany('App\Models\CargaLectiva','cargalectiva_curso');
    }
}
