<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $casts = [
    'fecha_venta' => 'datetime',
];

    protected $fillable = [
        'user_id',
    'fecha_venta',
    'total',
    'estado_venta', // 👈 usamos estado_venta en lugar de estado
    'tipo_entrega',
    'direccion_envio',
    'latitud',
    'longitud',
    'telefono_contacto',
    'comprobante_pago',
    'estado_pago',
    'fecha_verificacion',
    'comentarios_verificacion',
    ];

    protected $dates = ['fecha_venta', 'fecha_verificacion'];

    // ✅ Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Relación con detalles
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function agricultor()
{
    return $this->belongsTo(User::class, 'agricultor_id');
}

    
}
