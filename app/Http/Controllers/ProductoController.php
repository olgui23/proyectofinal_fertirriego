<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

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
            'disponible' => 'boolean'
        ]);

        $data = $request->all();

        // Guardar imagen si se sube
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('productos', 'public');
            $data['image_url'] = 'storage/' . $path;
        }

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente');
    }

    public function edit($id)
{
    $producto = Producto::findOrFail($id);
    return view('productos.editar', compact('producto'));
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

}
