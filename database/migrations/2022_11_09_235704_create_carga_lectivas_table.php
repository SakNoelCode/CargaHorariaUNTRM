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
        Schema::create('carga_lectivas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('estado_asignado')->default(0);
            $table->tinyInteger('estado_terminado')->default(0);
            $table->foreignId('declaracionJurada_id')->constrained('declaracion_juradas')->onDelete('cascade');
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
        Schema::dropIfExists('carga_lectivas');
    }
};
