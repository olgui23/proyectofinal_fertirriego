<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    // ✅ Relación con venta
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    // ✅ Relación con producto
        public function producto()
        {
    return $this->belongsTo(Producto::class, 'producto_id');
        }

}
