<?php

namespace App\Services;

use App\Handlers\CrudHandler;
use App\Models\Ordene;

class OrdenService
{
    protected CrudHandler $handler;

    public function __construct(CrudHandler $handler)
    {
        $this->handler = $handler;
    }

    public function getAll()
    {
        return Ordene::with(['cliente', 'detalles'])->get();
    }

    public function getById(int $id): ?Ordene
    {
        return Ordene::with(['cliente', 'detalles'])->find($id);
    }

    public function create(array $data): Ordene
    {
        return $this->handler->create(Ordene::class, $data);
    }

    public function update(int $id, array $data): ?Ordene
    {
        $orden = Ordene::find($id);

        if (!$orden) {
            return null;
        }

        return $this->handler->update($orden, $data);
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
