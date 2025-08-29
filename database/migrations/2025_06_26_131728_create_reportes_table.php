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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_registro');
            $table->string('tipo_lechuga');
            $table->decimal('superficie', 8, 2);
            $table->string('unidad_medida');
            $table->string('etapa_crecimiento');
            $table->string('estado_cultivo');
            $table->string('estacion_anio');
            $table->text('observaciones')->nullable();
            $table->string('foto_cultivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
