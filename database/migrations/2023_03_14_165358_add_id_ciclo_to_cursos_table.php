<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->tinyInteger('estado')->after('tipo')->default(1);
        });
        Schema::table('cursos', function (Blueprint $table) {
            $table->foreignId('ciclo_id')->after('estado')->nullable()->constrained('cursos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['ciclo_id']);
            $table->dropColumn('ciclo_id');
            $table->dropColumn('estado');
        });
    }
};
