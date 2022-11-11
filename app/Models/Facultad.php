<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;

    protected $table = 'facultads';

    protected $fillable = ['descripcion'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function escuela(){
        return $this->hasMany('App\Models\Escuela');
    }
}
