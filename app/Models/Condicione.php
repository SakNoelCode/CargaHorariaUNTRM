<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicione extends Model
{
    use HasFactory;

    protected $table = 'condiciones';

    protected $fillable = ['descripcion'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function docente(){
        return $this->hasMany('App\Models\Docente');
    }
}
