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
        return $this->belongsTo('App\Models\Modalidade','modalidad_id');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }

    public function condicione(){
        return $this->belongsTo('App\Models\Condicione','condicion_id');
    }

    public function declaracionJurada(){
        return $this->hasMany('App\Models\DeclaracionJurada');
    }

    public function especialidades(){
        return $this->belongsToMany(Especialidade::class)->withTimestamps();
    }

    //Relaciones Eloquent
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
