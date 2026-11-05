<?php

namespace App\Repositories\Slider;

use App\Models\Slider;

class SliderRepository implements SliderInterface
{
    public function fetch()
    {
        return Slider::query();
    }

    public function store(array $data): Slider
    {   
        $data['user_id'] = user()->id;
        return Slider::create($data);
    }

    public function update(array $data, Slider $slider): Slider
    {
        $slider->update($data);
        return $slider;
    }

    public function delete(Slider $slider): bool
    {
        return $slider->delete();
    }

    public function statusUpdate(Slider $slider, string $status): Slider
    {
        $slider->update([
            'status' => $status
        ]);

        return $slider;
    }
}