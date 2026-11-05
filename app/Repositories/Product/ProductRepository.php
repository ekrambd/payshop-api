<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductInterface
{
    public function fetch()
    {
        return Product::query();
    }

    public function store(array $data): Product
    {
        return Product::create($data);
    }

    public function update(array $data, Product $product): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function updateStatus(Product $product, string $status): Product
    {
        $product->update([
            'status' => $status
        ]);

        return $product;
    }
}