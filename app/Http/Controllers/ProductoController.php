<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
 public function index(Request $request)
{
    $query = Producto::query()->where('disponible', 1);

    // 🔍 FILTRO DE BÚSQUEDA
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('descripcion', 'like', "%{$search}%")
              ->orWhere('categoria', 'like', "%{$search}%")
              ->orWhere('origen', 'like', "%{$search}%");
        });
    }

    // 🔄 ORDENAMIENTO
    if ($request->filled('sort')) {
        switch ($request->input('sort')) {
            case 'name':
                $query->orderBy('nombre', 'asc');
                break;
            case 'price-low':
                $query->orderBy('precio', 'asc');
                break;
            case 'price-high':
                $query->orderBy('precio', 'desc');
                break;
            case 'stock':
                $query->orderBy('stock', 'desc');
                break;
        }
    }

    // 📄 PAGINACIÓN (opcional)
    $productos = $query->paginate(9)->appends($request->query());

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

public function catalogoPDF()
{
    $productos = Producto::with('user')
        ->where('disponible', true)
        ->where('stock', '>', 0)
        ->get();

    $fecha_impresion = now()->format('d/m/Y H:i');

    // Calculamos el stock total
    $stock_total = $productos->sum('stock');

    $pdf = PDF::loadView('productos.catalogo_pdf', [
        'productos' => $productos,
        'fecha_impresion' => $fecha_impresion,
        'stock_total' => $stock_total // ✅ pasamos la variable
    ])->setPaper('a4', 'portrait');

    return $pdf->stream('catalogo_productos.pdf');
}


}
