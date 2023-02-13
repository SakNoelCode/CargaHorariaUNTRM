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
        Schema::table('detalle_carga_horaria', function (Blueprint $table) {
            $table->dropColumn('hora_inicio');
            $table->dropColumn('hora_fin');
        });

        Schema::table('detalle_carga_horaria', function (Blueprint $table) {
            $table->foreignId('hora_inicio_id')->after('tipo')->constrained('horas')->onDelete('cascade');
        });

        Schema::table('detalle_carga_horaria', function (Blueprint $table) {
            $table->foreignId('hora_fin_id')->after('hora_inicio_id')->constrained('horas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('detalle_carga_horaria', function (Blueprint $table) {
            $table->time('hora_inicio')->after('tipo');
        });

        Schema::table('detalle_carga_horaria', function (Blueprint $table) {
            $table->time('hora_fin')->after('hora_inicio');
        });

        Schema::table('detalle_carga_horaria', function (Blueprint $table) {
            $table->dropForeign(['hora_inicio_id']);
            $table->dropColumn('hora_inicio_id');
            $table->dropForeign(['hora_fin_id']);
            $table->dropColumn('hora_fin_id');
        });
    }
};
