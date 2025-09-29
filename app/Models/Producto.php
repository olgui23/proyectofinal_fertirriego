<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;



class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = [
    'nombre', 'image_url', 'descripcion', 'precio',
    'unidad', 'stock', 'origen', 'beneficios', 'disponible', 'user_id'
];
public function user()
{
    return $this->belongsTo(User::class);
}
public function getImagePathAttribute()
{
    if ($this->image_url && Storage::disk('public')->exists($this->image_url)) {
        return asset('storage/' . $this->image_url);
    }

    // Imagen por defecto si el archivo no existe
    return asset('storage/productos/default.jpg');
}



}
