<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riego extends Model
{
    use HasFactory;

    protected $table = 'riegos'; // Indica la tabla asociada

    // Columnas que se pueden llenar masivamente
    protected $fillable = [
        'fecha_hora',
        'inicio',
        'fin',
        'lectura_adc',
        'humedad',
        'estado',
        'accion',
    ];

    public $timestamps = true; // Para created_at y updated_at
}
