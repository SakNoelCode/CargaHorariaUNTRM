<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    use HasFactory;

    protected $table = 'modalidades';

    protected $fillable = ['descripcion','horas'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function docente(){
        return $this->hasMany('App\Models\Docente','modalidad_id');
    }
}
