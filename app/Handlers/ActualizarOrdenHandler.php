<?php

namespace App\Handlers;

use Illuminate\Support\Facades\DB;
use App\Models\Ordene;
use App\Models\Producto;
use Exception;

class ActualizarOrdenHandler
{
    public function handle(int $id, array $datosValidados): Ordene
    {
        return DB::transaction(function () use ($datosValidados, $id) {
            $orden = Ordene::with('detalles')->findOrFail($id);
            $detalle = $orden->detalles->first(); // Asumimos 1 detalle por orden basado en el flujo de creación

            $oldProductoId = $detalle->producto_id;
            $oldCantidad = $detalle->cantidad;
            $newProductoId = $datosValidados['producto_id'];
            $newCantidad = $datosValidados['cantidad'];

            $productoNuevo = Producto::findOrFail($newProductoId);

            // Lógica de modificación de Producto/Stock
            if ($oldProductoId != $newProductoId) {
                $productoViejo = Producto::findOrFail($oldProductoId);

                // 1. Verificar stock del nuevo producto
                if ($productoNuevo->stock < $newCantidad) {
                    throw new Exception('No hay suficiente stock para el producto nuevo: ' . $productoNuevo->nombre);
                }

                // 2. Restaurar stock al producto viejo
                $productoViejo->stock += $oldCantidad;
                $productoViejo->save();

                // 3. Descontar stock del producto nuevo
                $productoNuevo->stock -= $newCantidad;
                $productoNuevo->save();

                // 4. Actualizar el registro del detalle
                $detalle->producto_id = $newProductoId;
                $detalle->cantidad = $newCantidad;
                $detalle->precio_unitario = $productoNuevo->precio;
                $detalle->save();
            } else {
                // Es el mismo producto, verificamos la variación de la cantidad
                if ($oldCantidad != $newCantidad) {
                    $diferencia = $newCantidad - $oldCantidad;

                    if ($diferencia > 0) {
                        if ($productoNuevo->stock < $diferencia) {
                            throw new Exception('No hay suficiente stock adicional para el producto: ' . $productoNuevo->nombre);
                        }
                        $productoNuevo->stock -= $diferencia;
                    } else {
                        $productoNuevo->stock += abs($diferencia);
                    }
                    $productoNuevo->save();

                    $detalle->cantidad = $newCantidad;
                    $detalle->precio_unitario = $productoNuevo->precio; // Actualizamos por si el precio base cambió
                    $detalle->save();
                }
            }

            // Lógica de Envío y actualización general de la Orden
            $oldEnvioStatus = $orden->getRawOriginal('envio'); // getRawOriginal Evita colisión de nombre entre columna/relación

            $orden->clientes_id = $datosValidados['clientes_id'];
            $orden->envio = $datosValidados['envio'];
            $orden->total = $detalle->cantidad * $detalle->precio_unitario;
            $orden->save();

            if ($datosValidados['envio'] && !$oldEnvioStatus) {
                $orden->envio()->create(['cliente_id' => $orden->clientes_id, 'fecha_envio' => now()]);
            } elseif (!$datosValidados['envio'] && $oldEnvioStatus) {
                $orden->envio()->delete();
            } elseif ($datosValidados['envio'] && $oldEnvioStatus) {
                // Si ya tenía envío, pero pudo cambiar el cliente asociado, actualizamos
                $orden->envio()->update(['cliente_id' => $orden->clientes_id]);
            }

            return $orden->load('detalles', 'envio');
        });
    }
}
