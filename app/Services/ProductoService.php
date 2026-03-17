<?php

namespace App\Services;

use App\Handlers\CrudHandler;
use App\Models\Producto;

class ProductoService
{
    protected CrudHandler $handler;

    public function __construct(CrudHandler $handler)
    {
        $this->handler = $handler;
    }

    public function getAll()
    {
        return Producto::all();
    }

    public function getById(int $id): ?Producto
    {
        return Producto::find($id);
    }

    public function create(array $data): Producto
    {
        return $this->handler->create(Producto::class, $data);
    }

    public function update(int $id, array $data): ?Producto
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return null;
        }

        return $this->handler->update($producto, $data);
    }

    public function delete(int $id): bool
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return false;
        }

        return $this->handler->delete($producto);
    }
}
