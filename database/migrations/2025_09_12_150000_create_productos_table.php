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
        Schema::create('productos', function (Blueprint $table) {
             $table->id();
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
            $table->index('disponible');
            $table->index('categoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
