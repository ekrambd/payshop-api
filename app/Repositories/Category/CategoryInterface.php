<?php

namespace App\Repositories\Category;

use App\Models\Category;

interface CategoryInterface
{
    public function fetch();

    public function store(array $data): Category;

    public function update(array $data, Category $category): Category;

    public function delete(Category $category): bool;

    public function statusUpdate(Category $category, string $status): Category;
}