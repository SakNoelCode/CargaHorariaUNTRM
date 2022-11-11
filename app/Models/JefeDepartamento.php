<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JefeDepartamento extends Model
{
    use HasFactory;

    protected $table = 'jefe_departamentos';

    protected $fillable = ['user_id','escuela_id'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function escuela(){
        return $this->belongsTo('App\Models\Escuela');
    }

    //Relaciones Eloquent
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
