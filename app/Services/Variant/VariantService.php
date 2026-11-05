<?php
namespace App\Services\Variant;

use App\Models\Variant;
use App\Repositories\Variant\VariantInterface;

class VariantService
{
    public function __construct(
        protected VariantInterface $variantRepository
    ) {}

    public function fetch()
    {
        return $this->variantRepository->fetch();
    }

    public function store(array $data)
    {
        $data['user_id'] = auth()->id();

        return $this->variantRepository->store($data);
    }

    public function update(array $data, Variant $variant)
    {
        return $this->variantRepository->update($data, $variant);
    }

    public function delete(Variant $variant)
    {
        return $this->variantRepository->delete($variant);
    }

    /* ================= PRODUCT VARIANT ================= */
    public function saveProductVariant(array $request)
    {
        return $this->variantRepository->saveProductVariant($request);
    }

    public function deleteProductVariant($variant)
    {
        return $this->variantRepository->deleteProductVariant($variant);
    }
}