<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaHoraria extends Model
{
    use HasFactory;

    protected $table = 'carga_horarias';
    protected $fillable = ['carga_lectiva_id'];
    protected $guarded = ['id'];

    /**
     * Relacion Eloquent 1:1 Inversa
     */
    public function cargaLectiva(){
        return $this->belongsTo('App\Models\CargaLectiva');
    }
}
