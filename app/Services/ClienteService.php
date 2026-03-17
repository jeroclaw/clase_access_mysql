<?php

namespace App\Services;

use App\Handlers\CrudHandler;
use App\Models\Cliente;
use Illuminate\Support\Facades\Log;

class ClienteService
{
    protected CrudHandler $handler;

    public function __construct(CrudHandler $handler)
    {
        $this->handler = $handler;
    }

    public function getAll()
    {
        try {
            return Cliente::with('ordenes')->get();
            //code...
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function getById(int $id)
    {
        try {
            return Cliente::with('ordenes')->find($id);
            //code...
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function create(array $data)
    {
        try {
            return $this->handler->create(Cliente::class, $data);
        } catch (\Throwable $th) {
            Log::error($th);
        }

    }

    public function update(int $id, array $data)
    {
        try {
            //code...
            $cliente = Cliente::find($id);

            if (!$cliente) {
                return null;
            }

            return $this->handler->update($cliente, $data);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function delete(int $id)
    {
        try {
            $cliente = Cliente::find($id);

            if (!$cliente) {
                return false;
            }

            return $this->handler->delete($cliente);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
