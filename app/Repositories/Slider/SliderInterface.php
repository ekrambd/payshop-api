<?php

namespace App\Repositories\Slider;

use App\Models\Slider;

interface SliderInterface
{
    public function fetch();

    public function store(array $data): Slider;

    public function update(array $data, Slider $slider): Slider;

    public function delete(Slider $slider): bool;

    public function statusUpdate(Slider $slider, string $status): Slider;
}