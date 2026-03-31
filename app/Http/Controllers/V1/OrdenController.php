<?php

namespace App\Http\Controllers\v1;

use App\Services\OrdenService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class OrdenController extends Controller
{
    protected OrdenService $service;

    public function __construct(OrdenService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function show($id)
    {
        $orden = $this->service->getById($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        return response()->json($orden, 200);
    }

    public function store(Request $request)
    {
        try {
            $datosValidados = $request->validate([
                'clientes_id' => 'required|exists:clientes,id',
                'envio' => 'required|boolean',
                'producto_id' => 'required|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
            ]);

            $orden = $this->service->create($datosValidados);

            // Cargar relaciones para la respuesta
            $orden->load('detalles', 'envio');

            return response()->json([
                'message' => 'Orden creada correctamente',
                'data' => $orden
            ], 201);

        } catch (Exception $e) {
            Log::debug('entro');
            Log::debug($e);
            // Capturar cualquier excepción durante la transacción para dar una respuesta de error.
            return response()->json(['message' => 'Error al crear la orden: ' . $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $datosValidados = $request->validate([
                'clientes_id' => 'required|exists:clientes,id',
                'envio' => 'required|boolean',
                'producto_id' => 'required|exists:productos,id',
                'cantidad' => 'required|integer|min:1',
            ]);

            $orden = $this->service->update($id, $datosValidados);

            return response()->json(['message' => 'Orden actualizada correctamente', 'data' => $orden], 200);
        } catch (Exception $e) {
            Log::error('Error al actualizar la orden: ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar la orden: ' . $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        return response()->json([
            'message' => 'Orden eliminada correctamente'
        ], 200);
    }
}
