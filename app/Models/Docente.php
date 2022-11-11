<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = ['escuela_id', 'condicion_id', 'categoria_id', 'modalidad_id', 'user_id'];

    protected $guarded = ['id'];

    //Relaciones Eloquent
    public function escuela()
    {
        return $this->belongsTo('App\Models\Escuela');
    }

    public function modalidade()
    {
        return $this->belongsTo('App\Models\Modalidade');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }

    public function condicione(){
        return $this->belongsTo('App\Models\Condicione');
    }

    public function declaracionJurada(){
        return $this->hasMany('App\Models\DeclaracionJurada');
    }
}
