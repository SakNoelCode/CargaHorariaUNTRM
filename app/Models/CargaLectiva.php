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

    /*Relaciones Eloquent
    public function docente(){
        return $this->belongsTo('App\Models\Docente');
    }*/

    /**
     * Relación eloquent a la inversa 1:1
     * Recuperar la declaración Jurada de la carga Lectiva
     * @return App\Models\DeclaracionJurada
     */
    public function declaracionJurada(){
        return $this->belongsTo('App\Models\DeclaracionJurada','declaracionJurada_id');
    }
}
