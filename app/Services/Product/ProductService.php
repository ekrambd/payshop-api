<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Repositories\Product\ProductInterface;
use Image;

class ProductService
{
    public function __construct(
        protected ProductInterface $productRepository
    ) {}

    public function fetch()
    {
        return $this->productRepository->fetch();
    }

    /* ================= STORE ================= */
    public function store(array $data)
    {
        $count = Product::count() + 1;

        $data['user_id'] = auth()->id();
        $data['hit_count'] = 0;
        $data['subcategory_id'] = isset($data['subcategory_id'])?$data['subcategory_id']:NULL;
        $data['status'] = 'Inactive';
        $data['slug'] = Str::slug($data['product_name']) . '-' . $count;

        if (isset($data['featured_image'])) {


            // $imageName = time().'_'.auth()->id().'_'.$image->getClientOriginalName();

            // $image->move(public_path('uploads/products'), $imageName);

            // $data['featured_image'] = 'uploads/products/'.$imageName;

            // $position = strpos($data['featured_image'], ';');
            // $sub = substr($data['featured_image'], 0, $position);
            // $ext = explode('/', $sub)[1];

            $image = $data['featured_image'];

            $name = time().'_'.auth()->id().'_'.$image->getClientOriginalName();

            //$name = time().'_'.auth()->id().'_'.$ext;

            $uploadPath = public_path('uploads/products/');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image = Image::make($data['featured_image'])
                ->fit(1024, 1024, function ($constraint) {
                    $constraint->upsize();
                });

            $image->save($uploadPath . $name, 90);

            $data['featured_image'] = 'uploads/products/' . $name;
        } 

        return $this->productRepository->store($data);
    }

    /* ================= UPDATE ================= */
    public function update(array $data, Product $product)
    {
        $data['slug'] = Str::slug($data['product_name']);
        $data['subcategory_id'] = isset($data['subcategory_id'])?$data['subcategory_id']:$product->subcategory_id;

        if (isset($data['featured_image'])) {

            // ❌ DELETE OLD IMAGE
            if ($product->featured_image && file_exists(public_path($product->featured_image))) {
                unlink(public_path($product->featured_image));
            }

            // ✅ UPLOAD NEW IMAGE
            // $image = $data['featured_image'];

            // $imageName = time().'_'.auth()->id().'_'.$image->getClientOriginalName();

            // $image->move(public_path('uploads/products'), $imageName);

            // $data['featured_image'] = 'uploads/products/'.$imageName;

            $image = $data['featured_image'];

            $name = time().'_'.auth()->id().'_'.$image->getClientOriginalName();

            //$name = time().'_'.auth()->id().'_'.$ext;

            $uploadPath = public_path('uploads/products/');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image = Image::make($data['featured_image'])
                ->fit(1024, 1024, function ($constraint) {
                    $constraint->upsize();
                });

            $image->save($uploadPath . $name, 90);

            $data['featured_image'] = 'uploads/products/' . $name;
        }

        return $this->productRepository->update($data, $product);
    }

    /* ================= DELETE ================= */
    public function delete(Product $product)
    {
        // ❌ DELETE IMAGE BEFORE PRODUCT DELETE
        if ($product->featured_image && file_exists(public_path($product->featured_image))) {
            unlink(public_path($product->featured_image));
        }

        return $this->productRepository->delete($product);
    }

    public function updateStatus($productId, $status)
    {
        $product = Product::findOrFail($productId);

        return $this->productRepository->updateStatus($product, $status);
    }
}