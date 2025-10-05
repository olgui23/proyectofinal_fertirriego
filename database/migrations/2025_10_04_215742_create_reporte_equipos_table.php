<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte_equipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipo_id');
            $table->string('tipo_accion', 50);       // 'riego_manual', 'riego_auto', 'fertilizante'
            $table->string('valor')->nullable();     // nivel humedad, tiempo, etc.
            $table->tinyInteger('estado')->default(1); // 1=activo, 0=finalizado, 2=error
            $table->timestamps(); // created_at y updated_at

            $table->foreign('equipo_id')
                  ->references('id')
                  ->on('equipos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_equipos');
    }
};
