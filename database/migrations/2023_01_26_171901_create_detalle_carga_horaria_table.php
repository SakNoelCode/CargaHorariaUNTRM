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
        Schema::create('detalle_carga_horaria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cargahoraria_id')->constrained('carga_horarias')->onDelete('cascade');
            $table->foreignId('cargalectiva_carga_id')->nullable()->constrained('cargalectiva_carga')->onDelete('cascade');
            $table->foreignId('cargalectiva_curso_id')->nullable()->constrained('cargalectiva_curso')->onDelete('cascade');
            $table->foreignId('aula_id')->constrained('aulas')->onDelete('cascade');
            $table->string('dia',45);
            $table->string('tipo',45);
            $table->time('hora_inicio');
            $table->time('hora_fin');
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
        Schema::dropIfExists('detalle_carga_horaria');
    }
};
