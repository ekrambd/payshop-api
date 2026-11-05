<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryChargeRequest extends FormRequest
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
        return [
            'inside_base_charge' => 'required|numeric',
            'outside_base_charge' => 'required|numeric',
            'per_weight_charge' => 'required|numeric',
            'product_weight' => 'required|numeric',
        ];
    }
}
