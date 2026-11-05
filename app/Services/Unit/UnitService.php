<?php

namespace App\Services\Unit;

use App\Models\Unit;
use App\Repositories\Unit\UnitInterface;

class UnitService
{
    public function __construct(
        protected UnitInterface $unitRepository
    ) {}

    public function fetch()
    {
        return $this->unitRepository->fetch();
    }

    public function store(array $data)
    {
        $data['user_id'] = auth()->id();

        return $this->unitRepository->store($data);
    }

    public function update(array $data, Unit $unit)
    {
        return $this->unitRepository->update($data, $unit);
    }

    public function delete(Unit $unit)
    {
        return $this->unitRepository->delete($unit);
    }
}