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
        Schema::create('carga_horarias', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('estado_terminado')->nullable()->default(0);
            $table->foreignId('cargalectiva_id')->unique()->constrained('carga_lectivas')->onDelete('cascade');
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
        Schema::dropIfExists('carga_horarias');
    }
};
