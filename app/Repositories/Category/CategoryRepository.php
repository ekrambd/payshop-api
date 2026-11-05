<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository implements CategoryInterface
{
    public function fetch()
    {
        return Category::query();
    }

    public function store(array $data): Category
    {   
        $data['user_id'] = user()->id;
        $data['slug'] = categorySlug($data['category_name']);
        return Category::create($data);
    }

    public function update(array $data, Category $category): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function statusUpdate(Category $category, string $status): Category
    {
        $category->update([
            'status' => $status
        ]);

        return $category;
    }
}