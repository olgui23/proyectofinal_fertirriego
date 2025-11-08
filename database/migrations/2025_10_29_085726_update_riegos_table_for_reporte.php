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
        Schema::table('riegos', function (Blueprint $table) {
            // 🔹 Verificamos si existen y eliminamos las columnas antiguas
            if (Schema::hasColumn('riegos', 'metodo')) {
                $table->dropColumn('metodo');
            }
            if (Schema::hasColumn('riegos', 'cantidad_litros')) {
                $table->dropColumn('cantidad_litros');
            }
            if (Schema::hasColumn('riegos', 'automatico')) {
                $table->dropColumn('automatico');
            }

            // 🔹 Agregamos las nuevas columnas del reporte
            $table->time('inicio')->nullable()->after('fecha_hora');
            $table->time('fin')->nullable()->after('inicio');
            $table->integer('lectura_adc')->nullable()->after('fin');
            $table->decimal('humedad', 5, 2)->nullable()->after('lectura_adc');
            $table->string('estado', 50)->nullable()->after('humedad');
            $table->string('accion', 100)->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riegos', function (Blueprint $table) {
            // 🔹 Revertir cambios - eliminar las nuevas columnas
            $table->dropColumn(['inicio', 'fin', 'lectura_adc', 'humedad', 'estado', 'accion']);

            // 🔹 Restaurar las columnas originales si fuera necesario
            $table->string('metodo')->nullable();
            $table->decimal('cantidad_litros', 8, 2)->nullable();
            $table->boolean('automatico')->default(0);
        });
    }
};