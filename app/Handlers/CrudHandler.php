<?php

namespace App\Handlers;

class CrudHandler
{
    public function create($model, array $data)
    {
        return $model::create($data);
    }

    public function update($modelInstance, array $data)
    {
        $modelInstance->update($data);
        return $modelInstance;
    }

    public function delete($modelInstance)
    {
        return $modelInstance->delete();
    }
}
