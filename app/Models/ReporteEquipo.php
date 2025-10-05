<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteEquipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'tipo_accion',
        'valor',
        'estado',
    ];

    // Relación con Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}
