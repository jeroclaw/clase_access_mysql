<?php

namespace App\Handlers;

use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Ordene;
use Exception;

class CrearOrdenHandler
{
    public function handle(array $datosValidados): Ordene
    {
        return DB::transaction(function () use ($datosValidados) {
            $producto = Producto::findOrFail($datosValidados['producto_id']);

            // 1. Validar stock
            if ($producto->stock < $datosValidados['cantidad']) {
                throw new Exception('No hay suficiente stock para el producto: ' . $producto->nombre);
            }

            // 2. Calcular total.
            $precioUnitario = $producto->precio;
            $totalOrden = $datosValidados['cantidad'] * $precioUnitario;

            // 3. Crear la orden
            $orden = Ordene::create([
                'clientes_id' => $datosValidados['clientes_id'],
                'total' => $totalOrden,
                'envio' => $datosValidados['envio'],
            ]);

            // 4. Crear el detalle de la orden
            $orden->detalles()->create([
                'producto_id' => $datosValidados['producto_id'],
                'cantidad' => $datosValidados['cantidad'],
                'precio_unitario' => $precioUnitario,
            ]);

            // 5. Actualizar stock del producto
            $producto->stock -= $datosValidados['cantidad'];
            $producto->save();

            // 6. Si hay envío, crear registro en la tabla de envíos
            if ($orden->envio) {
                $orden->envio()->create([
                    'cliente_id' => $orden->clientes_id,
                    'fecha_envio' => now(),
                ]);
            }

            return $orden;
        });
    }
}
