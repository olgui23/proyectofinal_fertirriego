<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_ventas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->dateTime('fecha_venta')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('total', 10, 2);

            $table->string('estado')->default('pendiente'); // pendiente, pagado, enviado, cancelado

            $table->enum('tipo_entrega', ['recojo', 'envio'])->default('recojo');
            $table->text('direccion_envio')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();

            $table->string('telefono_contacto');

            $table->string('comprobante_pago')->nullable(); // Ruta del archivo
            $table->string('estado_pago')->default('pendiente'); // pendiente, verificado, rechazado
            $table->dateTime('fecha_verificacion')->nullable();
            $table->text('comentarios_verificacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
