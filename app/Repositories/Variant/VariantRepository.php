<?php
namespace App\Repositories\Variant;

use App\Models\Variant;
use App\Models\ProductVariant;
class VariantRepository implements VariantInterface
{
    public function fetch()
    {
        return Variant::query();
    }

    public function store(array $data): Variant
    {
        return Variant::create($data);
    }

    public function update(array $data, Variant $variant): Variant
    {
        $variant->update($data);
        return $variant;
    }

    public function delete(Variant $variant): bool
    {
        return $variant->delete();
    }

     /* ================= PRODUCT VARIANT SAVE ================= */
    public function saveProductVariant(array $request)
    {
        $product_id = $request['product_id'];
        $variant_values = $request['variant_values'] ?? [];
        $variant_prices = $request['variant_prices'] ?? [];
        $stock_qtys = $request['stock_qtys'] ?? [];
        $images = $request['images'] ?? [];
        $productvariant_ids = $request['productvariant_ids'] ?? [];

        foreach ($variant_values as $variant_id => $values) {
            foreach ($values as $index => $value) {

                if (empty($value)) continue;

                $pv_id = $productvariant_ids[$variant_id][$index] ?? null;

                $data = [
                    'product_id'    => $product_id,
                    'variant_id'    => $variant_id,
                    'variant_value' => $value,
                    //'variant_price' => $variant_prices[$variant_id][$index] ?? null,
                    //'stock_qty'     => $stock_qtys[$variant_id][$index] ?? 0,
                ];

                /* IMAGE UPLOAD */
                if (isset($images[$variant_id][$index]) && $images[$variant_id][$index]->isValid()) {

                    $file = $images[$variant_id][$index];

                    $imageName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                    $file->move(public_path('uploads/variants'), $imageName);

                    $data['image'] = 'uploads/variants/' . $imageName;
                }

                if ($pv_id && $existing = ProductVariant::find($pv_id)) {
                    $existing->update($data);
                } else {
                    ProductVariant::create($data);
                }
            }
        }

        return true;
    }

    /* ================= DELETE PRODUCT VARIANT ================= */
    public function deleteProductVariant(ProductVariant $variant): bool
    {
        if ($variant->image && file_exists(public_path($variant->image))) {
            unlink(public_path($variant->image));
        }

        return $variant->delete();
    }
}