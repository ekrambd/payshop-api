<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryInterface;
use Image;

class CategoryService
{
    public function __construct(
        protected CategoryInterface $categoryRepository
    ) {}

    public function fetch()
    {
        return $this->categoryRepository->fetch();
    }

    public function store(array $data): Category
    {
        // Image upload logic
        // if (isset($data['image'])) {
        //     $data['image'] = $this->uploadImage($data['image']);
        // }
        
        
        $image = $data['image'];

        $name = time().'_'.auth()->id().'_'.$image->getClientOriginalName();

        //$name = time().'_'.auth()->id().'_'.$ext;

        $uploadPath = public_path('uploads/categories/');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $image = Image::make($data['image'])
            ->fit(500, 500, function ($constraint) {
                $constraint->upsize();
            });

        $image->save($uploadPath . $name, 90);

        //$data['image'] = 'uploads/categories/' . $name;
        
        $data['image'] = $name;    
        
        // Default status
        $data['status'] = $data['status'] ?? 'Active';

        return $this->categoryRepository->store($data);
    }

    public function update(array $data, Category $category): Category
    {
        // Old image delete + new upload (optional improvement)
        if (isset($data['image'])) {
            if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->image));
            }

            $image = $data['image'];

            $name = time().'_'.auth()->id().'_'.$image->getClientOriginalName();
    
            //$name = time().'_'.auth()->id().'_'.$ext;
    
            $uploadPath = public_path('uploads/categories/');
    
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
    
            $image = Image::make($data['image'])
                ->fit(500, 500, function ($constraint) {
                    $constraint->upsize();
                });
    
            $image->save($uploadPath . $name, 90);
    
            //$data['image'] = 'uploads/categories/' . $name;
            $data['image'] = $name;
        }else{
            $data['image'] = $category->image;
        }

        return $this->categoryRepository->update($data, $category);
    }

    public function delete(Category $category): bool
    {
        // delete image
        if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
            unlink(public_path('uploads/categories/' . $category->image));
        }

        return $this->categoryRepository->delete($category);
    }

    public function statusUpdate(Category $category, string $status): Category
    {
        return $this->categoryRepository->statusUpdate($category, $status);
    }

    /**
     * Upload Image Helper
     */
    private function uploadImage($image): string
    {
        $fileName = time() . '_' . user()->id . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('uploads/categories'), $fileName);

        return $fileName;
    }
}