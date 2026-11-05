<?php
 namespace App\Repositories\Unit;
 use App\Models\Unit;
 
class UnitRepository implements UnitInterface
{
    public function fetch()
    {
        return Unit::query();
    }

    public function store(array $data): Unit
    {   
        return Unit::create($data);
    }

    public function update(array $data, Unit $unit): Unit
    {
        $unit->update($data);
        return $unit;
    }

    public function delete(Unit $unit): bool
    {
        return $unit->delete();
    }
}