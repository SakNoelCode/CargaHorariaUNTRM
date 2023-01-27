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
        Schema::create('cargalectiva_carga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cargalectiva_id')->constrained('carga_lectivas')->onDelete('cascade');
            $table->foreignId('carga_id')->constrained('cargas')->onDelete('cascade');
            $table->string('descripcion',200)->nullable();
            $table->integer('cantidad_horas')->nullable();
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
        Schema::dropIfExists('cargalectiva_carga');
    }
};
