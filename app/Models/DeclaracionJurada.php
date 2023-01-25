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

    //Relaciones Eloquent
    public function docente(){
        return $this->belongsTo('App\Models\Docente');
    }

    public function periodo(){
        return $this->belongsTo('App\Models\Periodo');
    }

    /**
     * Acceder a la carga lectiva de la declaración Jurada 1:1
     */
    public function cargaLectiva(){
        return $this->hasOne('App\Models\CargaLectiva','declaracionJurada_id');
    }
}
