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
        // ⚠ Deshabilitar temporalmente las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Eliminar tabla vieja si existe
        Schema::dropIfExists('ventas');

        // ⚠ Habilitar nuevamente las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Crear tabla nueva ventas
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->dateTime('fecha_venta')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('total', 10, 2);

            // Estado de la venta
            $table->enum('estado_venta', ['pendiente','aprobado','rechazado','finalizado','cancelado'])
                  ->default('pendiente');

            // Tipo de entrega
            $table->enum('tipo_entrega', ['recojo','envio'])->default('recojo');

            // Dirección y contacto
            $table->text('direccion_envio')->nullable();
            $table->string('telefono_contacto');

            // Geolocalización (si aplica)
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();

            // Estado del comprobante del cliente
            $table->enum('estado_pago', ['pendiente','verificado','rechazado'])
                  ->default('pendiente');

            // Comprobantes
            $table->string('comprobante_pago')->nullable();       // Subido por cliente
            $table->string('comprobante_sistema')->nullable();    // PDF generado por el sistema

            // Estado activo/inactivo
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
