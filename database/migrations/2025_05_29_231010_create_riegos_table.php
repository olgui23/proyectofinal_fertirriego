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
        Schema::create('riegos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora');
            $table->string('metodo');
            $table->decimal('cantidad_litros', 8, 2);
            $table->boolean('automatico')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riegos');
    }
};
