<?php

namespace App\Services\Slider;

use App\Models\Slider;
use App\Repositories\Slider\SliderInterface;

class SliderService
{
    public function __construct(
        protected SliderInterface $sliderRepository
    ) {}

    public function fetch()
    {
        return $this->sliderRepository->fetch();
    }

    public function store(array $data): Slider
    {
        // Image upload logic
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        // Default status
        $data['status'] = $data['status'] ?? 'Active';

        return $this->sliderRepository->store($data);
    }

    public function update(array $data, Slider $slider): Slider
    {
        // Old image delete + new upload (optional improvement)
        if (isset($data['image'])) {
            if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
                unlink(public_path('uploads/sliders/' . $slider->image));
            }

            $data['image'] = $this->uploadImage($data['image']);
        }

        return $this->sliderRepository->update($data, $slider);
    }

    public function delete(Slider $slider): bool
    {
        // delete image
        if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
            unlink(public_path('uploads/sliders/' . $slider->image));
        }

        return $this->sliderRepository->delete($slider);
    }

    public function statusUpdate(Slider $slider, string $status): Slider
    {
        return $this->sliderRepository->statusUpdate($slider, $status);
    }

    /**
     * Upload Image Helper
     */
    private function uploadImage($image): string
    {
        $fileName = time() . '_' . user()->id . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('uploads/sliders'), $fileName);

        return $fileName;
    }
}