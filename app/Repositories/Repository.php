<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepository;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int|string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int|string $id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete(int|string $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
