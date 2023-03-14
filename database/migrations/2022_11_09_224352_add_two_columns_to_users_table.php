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
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni',8)->after('email')->nullable();
            $table->string('status')->after('dni')->default('ACTIVO');
            $table->foreignId('rol_id')->after('password')->nullable()->constrained('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dni');
            $table->dropForeign(['rol_id']);
            $table->dropColumn('rol_id');
        });
    }
};
