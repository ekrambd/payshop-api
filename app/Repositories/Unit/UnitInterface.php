<?php

namespace App\Repositories\Unit;

use App\Models\Unit;

interface UnitInterface
{
    public function fetch();

    public function store(array $data): Unit;

    public function update(array $data, Unit $unit): Unit;

    public function delete(Unit $unit): bool;
}