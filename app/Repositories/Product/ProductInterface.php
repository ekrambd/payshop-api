<?php
namespace App\Repositories\Product;

use App\Models\Product;

interface ProductInterface
{
    public function fetch();
    public function store(array $data): Product;
    public function update(array $data, Product $product): Product;
    public function delete(Product $product): bool;
    public function updateStatus(Product $product, string $status): Product;
}