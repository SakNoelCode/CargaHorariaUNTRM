<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $table = 'aulas';

    protected $fillable = ['descripcion','local_id'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function local(){
        return $this->belongsTo('App\Models\Local','local_id','id');
    }
}
