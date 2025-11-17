<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        Log::info("👉 Entró al método store", $request->all());

        // Decodificar productos si vienen como JSON
        if (is_string($request->productos)) {
            $productos = json_decode($request->productos, true);
            $request->merge(['productos' => $productos]);
        }

        Log::info("📦 Productos decodificados:", $request->productos ?? []);

        try {
            $request->validate([
                'productos' => 'required|array|min:1',
                'productos.*.id' => 'required|exists:productos,id',
                'productos.*.cantidad' => 'required|integer|min:1',
                'tipo_entrega' => 'required|in:recojo,envio',
                'telefono_contacto' => 'required|string|max:20',
                'comprobante_pago' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
                'direccion_envio' => 'nullable|string',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
            ]);
        } catch (ValidationException $e) {
            Log::error("❌ Error de validación en store:", $e->errors());
            return response()->json([
                'success' => false,
                'message' => '❌ Error de validación de datos.',
                'errors' => $e->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Guardar imagen del comprobante
            $comprobantePath = $request->file('comprobante_pago')->store('comprobantes', 'public');

            // Calcular total
            $total = 0;
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;
            }

            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión para comprar.',
                ], 403);
            }

            // Crear venta usando estado_venta
            $venta = Venta::create([
                'user_id' => Auth::id(),
                'fecha_venta' => Carbon::now(),
                'total' => $total,
                'estado_venta' => 'pendiente', // ✅ reemplazado
                'estado_pago' => 'pendiente',
                'tipo_entrega' => $request->tipo_entrega,
                'direccion_envio' => $request->tipo_entrega === 'envio' ? $request->direccion_envio : null,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'telefono_contacto' => $request->telefono_contacto,
                'comprobante_pago' => $comprobantePath,
            ]);

            // Guardar detalle venta
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);

                if ($item['cantidad'] > $producto->stock) {
                    throw new \Exception("No hay suficiente stock para {$producto->nombre}.");
                }

                $producto->stock -= $item['cantidad'];
                $producto->save();

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ Compra realizada con éxito.',
                'venta_id' => $venta->id,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error("❌ Error en store venta: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Error al procesar la compra.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $ventas = Venta::with(['user', 'detalles.producto'])->latest()->get();
        return view('productos.ventas', compact('ventas'));
    }

    public function aprobar($id)
{
    $venta = Venta::findOrFail($id);
    $venta->estado_venta = 'aprobado'; // 👈 corregido
    $venta->estado_pago = 'verificado';
    $venta->save();

    return back()->with('success', '✅ Venta aprobada correctamente.');
}

public function rechazar($id)
{
    $venta = Venta::findOrFail($id);
    $venta->estado_venta = 'cancelado'; // 👈 corregido
    $venta->estado_pago = 'rechazado';
    $venta->save();

    return back()->with('success', '❌ Venta rechazada.');
}



   // public function show($id)
    //{
      //  $venta = Venta::with(['user', 'detalles.producto'])->findOrFail($id);
        //return view('productos.detalleventa', compact('venta'));
   // }

    public function pdf($id)
    {
        $venta = Venta::with(['user', 'detalles.producto'])->findOrFail($id);
        $pdf = PDF::loadView('productos.comprobantepdf', compact('venta'));
        return $pdf->stream("comprobante_venta_{$venta->id}.pdf");
    }

    public function misCompras()
{
    $user = Auth::user();

    // Filtramos las ventas del comprador logueado
    $ventas = Venta::with(['detalles.producto'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();

    return view('productos.miscompras', compact('ventas'));
}
public function show($id)
{
    $venta = Venta::with(['detalles.producto', 'agricultor'])->findOrFail($id);

    if(request()->ajax()) {
        return view('productos.detalleventa_modal', compact('venta'));
    }

    return view('productos.detalleventa', compact('venta'));
}

public function reporte(Request $request)
{
    $query = Venta::query()->with(['user', 'detalles.producto']);

    $fecha_inicio = $request->fecha_inicio;
    $fecha_fin = $request->fecha_fin;

    if ($fecha_inicio) {
        $query->whereDate('fecha_venta', '>=', $fecha_inicio);
    }

    if ($fecha_fin) {
        $query->whereDate('fecha_venta', '<=', $fecha_fin);
    }

    if ($request->filled('estado')) {
        $query->where('estado_venta', $request->estado);
    }

    $ventas = $query->get();

    // 🔥 AHORA SÍ ENVIAMOS LAS FECHAS AL PDF
    $pdf = PDF::loadView('ventas.reporte', [
        'ventas' => $ventas,
        'fecha_inicio' => $fecha_inicio,
        'fecha_fin' => $fecha_fin,
        'estado' => $request->estado
    ]);

    return $pdf->stream('reporte_ventas.pdf');
}





}
