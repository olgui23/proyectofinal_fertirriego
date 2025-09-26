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

class VentaController extends Controller
{
    public function store(Request $request)
    {
        // 🔎 Log para verificar entrada completa
        Log::info("👉 Entró al método store", $request->all());

        // ✅ Decodificar productos si vienen como JSON string
        if (is_string($request->productos)) {
            $productos = json_decode($request->productos, true);
            $request->merge(['productos' => $productos]);
        }

        // 🔎 Log para ver productos decodificados
        Log::info("📦 Productos decodificados:", $request->productos ?? []);

        // 🚨 Validación con captura de errores
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
            // 📸 Guardar imagen del comprobante
            $comprobantePath = $request->file('comprobante_pago')->store('comprobantes', 'public');

            // 💰 Calcular total
            $total = 0;
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                $subtotal = $producto->precio * $item['cantidad'];
                $total += $subtotal;
            }

            // 🧾 Crear venta
            $venta = Venta::create([
                'user_id' => Auth::id() ?? 1,
                'fecha_venta' => Carbon::now(),
                'total' => $total,
                'estado' => 'pendiente',
                'estado_pago' => 'pendiente',
                'tipo_entrega' => $request->tipo_entrega,
                'direccion_envio' => $request->tipo_entrega === 'envio' ? $request->direccion_envio : null,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'telefono_contacto' => $request->telefono_contacto,
                'comprobante_pago' => $comprobantePath,
            ]);

            // 📦 Guardar detalle venta
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);

                // Validar stock
                if ($item['cantidad'] > $producto->stock) {
                    throw new \Exception("No hay suficiente stock para {$producto->nombre}.");
                }

                // Restar stock
                $producto->stock -= $item['cantidad'];
                $producto->save();

                // Crear detalle
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
}
