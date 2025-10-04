<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mac',
        'descripcion',
        'ubicacion',
        'lat',
        'lng',
        'fecha_instalacion',
        'activo',
    ];

    // Relación: un equipo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
