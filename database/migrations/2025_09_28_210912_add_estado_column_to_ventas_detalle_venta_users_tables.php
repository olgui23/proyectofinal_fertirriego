<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('ventas', function (Blueprint $table) {
        $table->boolean('estado')->default(1); // 👈 sin ->after()
    });

    Schema::table('detalle_venta', function (Blueprint $table) {
        $table->boolean('estado')->default(1);
    });

    Schema::table('users', function (Blueprint $table) {
        $table->boolean('estado')->default(1);
    });
}


    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('detalle_venta', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
