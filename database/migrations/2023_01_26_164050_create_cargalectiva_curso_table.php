<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargalectiva_curso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cargalectiva_id')->constrained('carga_lectivas')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('escuela_id')->constrained('escuelas')->onDelete('cascade');
            $table->foreignId('seccion_id')->constrained('seccions')->onDelete('cascade');
            $table->foreignId('ciclo_id')->constrained('ciclos')->onDelete('cascade');
            $table->integer('numero_alumnos')->nullable()->default(0);
            $table->integer('horas_teoria')->nullable()->default(0);
            $table->integer('horas_practica')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargalectiva_curso');
    }
};
