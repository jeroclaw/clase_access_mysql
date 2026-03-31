<?php

namespace App\Services;

use App\Handlers\CrudHandler;
use App\Handlers\CrearOrdenHandler;
use App\Handlers\ActualizarOrdenHandler;
use App\Models\Ordene;

class OrdenService
{
    protected CrudHandler $handler;
    protected CrearOrdenHandler $crearOrdenHandler;
    protected ActualizarOrdenHandler $actualizarOrdenHandler;

    public function __construct(CrudHandler $handler, CrearOrdenHandler $crearOrdenHandler, ActualizarOrdenHandler $actualizarOrdenHandler)
    {
        $this->handler = $handler;
        $this->crearOrdenHandler = $crearOrdenHandler;
        $this->actualizarOrdenHandler = $actualizarOrdenHandler;
    }

    public function getAll()
    {
        return Ordene::with(['cliente', 'detalles'])->get();
    }

    public function getById(int $id): ?Ordene
    {
        return Ordene::with(['cliente', 'detalles'])->find($id);
    }

    public function create(array $datosValidados): Ordene
    {
        return $this->crearOrdenHandler->handle($datosValidados);
    }

    public function update(int $id, array $data): ?Ordene
    {
        return $this->actualizarOrdenHandler->handle($id, $data);
    }

    public function delete(int $id): bool
    {
        $orden = Ordene::find($id);

        if (!$orden) {
            return false;
        }

        return $this->handler->delete($orden);
    }
}
