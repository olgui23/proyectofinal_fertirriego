<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ⚠ Opcional: deshabilitar temporalmente las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Eliminar tabla vieja si existe
        Schema::dropIfExists('ventas');

        // ⚠ Habilitar nuevamente las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Crear tabla nueva ventas
        Schema::create('ventas', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Soporte para llaves foráneas

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->dateTime('fecha_venta')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('total', 10, 2);

            $table->enum('estado_venta', ['pendiente','aprobado','rechazado','finalizado','cancelado'])
                  ->default('pendiente');

            $table->enum('tipo_entrega', ['recojo','envio'])->default('recojo');

            $table->text('direccion_envio')->nullable();
            $table->string('telefono_contacto');

            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();

            $table->enum('estado_pago', ['pendiente','verificado','rechazado'])
                  ->default('pendiente');

            $table->string('comprobante_pago')->nullable();       // Subido por cliente
            $table->string('comprobante_sistema')->nullable();    // PDF generado por el sistema

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('ventas');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
