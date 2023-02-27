<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['descripcion'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function user(){
        return $this->hasMany('App\Models\User','rol_id','id');
    }
}
