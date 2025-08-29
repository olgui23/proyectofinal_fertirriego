<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;
    protected $dates = ['fecha_registro']; 
    protected $fillable = [
        'fecha_registro', 'tipo_lechuga', 'superficie', 'unidad_medida', 'etapa_crecimiento', 'estado_cultivo', 'estacion_anio', 'observaciones', 'foto_cultivo'
    ];

    
}
