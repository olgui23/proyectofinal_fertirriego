<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function crear()
    {
        return view('productos.crear');
    }

  public function guardar(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:100',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|min:0',
        'unidad' => 'required|string|max:20',
        'stock' => 'required|integer|min:0',
        'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'origen' => 'nullable|string|max:100',
        'beneficios' => 'nullable|string',
        'disponible' => 'nullable|boolean'
    ]);

    $data = $request->all();

    // ✅ Subir imagen a storage/app/public/productos
    if ($request->hasFile('image_url')) {
        $path = $request->file('image_url')->store('productos', 'public');
        $data['image_url'] = 'storage/' . $path;  // Para usar con asset()
    }

    $data['user_id'] = auth()->id();
    $data['disponible'] = $request->has('disponible');

    Producto::create($data);

    return redirect()->route('productos.agricultor')->with('success', 'Producto agregado correctamente.');
}


   public function editar($id)
{
    $producto = Producto::findOrFail($id);
    return view('productos.editar', compact('producto'));
}

public function actualizar(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    // Validar datos (ejemplo)
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric',
        // más validaciones según tus campos
    ]);

    // Actualizar campos
    $producto->nombre = $request->nombre;
    $producto->descripcion = $request->descripcion;
    $producto->precio = $request->precio;
    $producto->unidad = $request->unidad;
    $producto->stock = $request->stock;
    $producto->origen = $request->origen;
    $producto->beneficios = $request->beneficios;
    $producto->disponible = $request->has('disponible');

    // Manejo imagen (opcional)
    if ($request->hasFile('image_url')) {
        $path = $request->file('image_url')->store('productos', 'public');
        $producto->image_url = $path;
    }

    $producto->save();

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}


public function eliminar($id)
{
    $producto = Producto::findOrFail($id);

    // Marcar como no disponible (eliminación lógica)
    $producto->disponible = false;
    $producto->save();

    return redirect()->route('productos.agricultor')->with('success', 'Producto marcado como no disponible.');
}



public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
        'unidad' => 'required|string|max:50',
        'stock' => 'required|integer|min:0',
        'image_url' => 'nullable|image|max:2048'
    ]);

    $producto->update($request->all());

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}

public function destroy($id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
}

public function misProductos()
{
    $userId = auth()->id();
    $productos = Producto::where('user_id', $userId)
                         ->where('disponible', true) // 👈 solo productos activos
                         ->get();
    return view('productos.agricultor', compact('productos'));
}

public function agricultor()
{
    $productos = Producto::where('user_id', auth()->id())
                         ->where('disponible', true) // 👈 solo productos activos
                         ->get();
    return view('productos.agricultor', compact('productos'));
}

public function toggleDisponible($id)
{
    $producto = Producto::findOrFail($id);
    $producto->disponible = !$producto->disponible;
    $producto->save();

    return back()->with('success', 'Disponibilidad actualizada.');
}


}
