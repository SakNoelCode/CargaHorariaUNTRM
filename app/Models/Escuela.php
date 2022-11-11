<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;

    protected $table = 'escuelas';

    protected $fillable = ['descripcion','facultad_id'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function facultad(){
        return $this->belongsTo('App\Models\Facultad');
    }

    public function jefeDepartamento(){
        return $this->hasOne('App\Models\JefeDepartamento');
    }

    public function docente(){
        return $this->hasMany('App\Models\Docente');
    }
}
