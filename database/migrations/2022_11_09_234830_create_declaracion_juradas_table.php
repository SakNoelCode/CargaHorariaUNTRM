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
        Schema::create('declaracion_juradas', function (Blueprint $table) {
            $table->id();
            $table->string('estado',45);
            $table->tinyInteger('estado_enviado')->nullable();
            $table->string('documento',255);
            $table->string('observaciones',255)->nullable();
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
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
        Schema::dropIfExists('declaracion_juradas');
    }
};
