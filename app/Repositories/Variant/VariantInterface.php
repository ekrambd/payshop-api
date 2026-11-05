<?php

namespace App\Repositories\Variant;

use App\Models\Variant;
use App\Models\ProductVariant;

interface VariantInterface
{
    public function fetch();

    public function store(array $data): Variant;

    public function update(array $data, Variant $variant): Variant;

    public function delete(Variant $variant): bool;

    public function saveProductVariant(array $data);

    public function deleteProductVariant(ProductVariant $variant): bool;
}