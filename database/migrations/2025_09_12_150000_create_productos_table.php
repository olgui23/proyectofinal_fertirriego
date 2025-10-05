<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            // 🔹 Relación con usuario que publica o administra el producto
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // 🔹 Información del producto
            $table->string('nombre', 100);
            $table->string('emoji', 5)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('unidad', 20)->nullable();
            $table->integer('stock')->default(0);
            $table->string('categoria', 50)->nullable();
            $table->string('origen', 100)->nullable();
            $table->text('beneficios')->nullable();
            $table->boolean('disponible')->default(true);

            $table->timestamps();

            // Índices útiles
            $table->index('disponible');
            $table->index('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
