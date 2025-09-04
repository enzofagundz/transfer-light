<?php

namespace App\Services;

use App\Repositories\Interfaces\BaseRepository;
use App\Services\Interfaces\BaseService;

abstract class Service implements BaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function get(int|string $id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int|string $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy(int|string $id)
    {
        return $this->repository->delete($id);
    }
}
