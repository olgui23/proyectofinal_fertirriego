<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean('activo')->default(true);
        });

        Schema::table('detalle_venta', function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean('activo')->default(true);
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean('activo')->default(true);
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('activo');
        });

        Schema::table('detalle_venta', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('activo');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('activo');
        });
    }
};
