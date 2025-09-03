<?php

namespace App\Services\Interfaces;

interface BaseService
{
    public function list();

    public function get($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}
