<?php

namespace App\Services\Interfaces;

interface BaseService
{
    public function all();

    public function get(int|string $id);

    public function store(array $data);

    public function update(int|string $id, array $data);

    public function destroy(int|string $id);
}
