<?php

namespace App\Services;

use App\Handlers\CrudHandler;
use App\Models\DetalleOrden;

class DetalleOrdenService
{
    protected CrudHandler $handler;

    public function __construct(CrudHandler $handler)
    {
        $this->handler = $handler;
    }

    public function getAll()
    {
        return DetalleOrden::with(['orden', 'producto'])->get();
    }

    public function getById(int $id): ?DetalleOrden
    {
        return DetalleOrden::with(['orden', 'producto'])->find($id);
    }

    public function create(array $data): DetalleOrden
    {
        return $this->handler->create(DetalleOrden::class, $data);
    }

    public function update(int $id, array $data): ?DetalleOrden
    {
        $detalle = DetalleOrden::find($id);

        if (!$detalle) {
            return null;
        }

        return $this->handler->update($detalle, $data);
    }

    public function delete(int $id): bool
    {
        $detalle = DetalleOrden::find($id);

        if (!$detalle) {
            return false;
        }

        return $this->handler->delete($detalle);
    }
}
