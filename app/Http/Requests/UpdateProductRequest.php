<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $productId = $this->product->id;

        return [
            'product_name'      => 'required|string|max:255|unique:products,product_name,' . $productId,
            'category_id'       => 'required|exists:categories,id',
            'subcategory_id'    => 'nullable|exists:subcategories,id',
            'unit_id'           => 'required|exists:units,id',

            'product_price'     => 'required|numeric|min:0',
            'product_discount'  => 'nullable|numeric|min:0',
            'stock_qty'         => 'required|numeric|min:0',

            'description'       => 'required|string',

            'featured_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status'            => 'nullable|in:Active,Inactive',
            'admin_verify'      => 'nullable|in:Yes,No',
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Product name is required',
            'category_id.required'  => 'Category is required',
            'unit_id.required'      => 'Unit is required',
        ];
    }
}
