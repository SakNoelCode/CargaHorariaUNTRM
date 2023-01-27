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

    /**
     * Relación eloquent a la inversa 1:1
     * Recuperar la declaración Jurada de la carga Lectiva
     * @return App\Models\DeclaracionJurada
     */
    public function declaracionJurada(){
        return $this->belongsTo('App\Models\DeclaracionJurada','declaracionJurada_id');
    }

    /**
     * Relación eloquent 1:1
     * Recuperar la carga horaria de la carga Lectiva
     * @return App\Models\CargaHoraria
     */
    public function cargaHoraria(){
        return $this->hasOne('App\Models\CargaHoraria');
    }

    /**
     * Relacion eloquent n:n con el modelo Carga
     */
    public function carga(){
        return $this->belongsToMany('App\Models\Carga','cargalectiva_carga');
    }

    /**
     * Relacion eloquent n:n con el modelo Curso
     */
    public function curso(){
        return $this->belongsToMany('App\Models\Curso','cargalectiva_curso');
    }
}
