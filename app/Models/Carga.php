<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use HasFactory;

    protected $table = 'cargas';

    protected $fillable = ['titulo','descripcion'];

    protected $guarded = ['id'];
}
