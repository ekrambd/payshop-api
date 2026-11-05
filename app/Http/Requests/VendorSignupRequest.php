<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorSignupRequest extends FormRequest
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
    public function rules():array
    {
        return [
            // USER
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'required|string|max:20|unique:users,phone',
            'password'              => 'required|string|min:6|confirmed',

            // VENDOR
            'shop_name'             => 'required|string|max:255',
            'nid_number'            => 'required|string|max:100|unique:vendors,nid_number',

            'nid_front'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nid_back'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'selfie_photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'trade_license_no'      => 'nullable|string|max:255',

            'tin_no'                => 'nullable|string|max:255',
            'tin_file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'bin_no'                => 'nullable|string|max:255',
            'bin_file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'bank_name'             => 'nullable|string|max:255',
            'branch_name'           => 'nullable|string|max:255',
            'account_name'          => 'nullable|string|max:255',
            'account_number'        => 'nullable|string|max:255',

            'cancelled_cheque'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'pickup_address'        => 'nullable|string',
            'return_address'        => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [

            'name.required'                 => 'Full name is required.',

            'email.required'                => 'Email is required.',
            'email.email'                   => 'Enter a valid email address.',
            'email.unique'                  => 'Email already exists.',

            'phone.required'                => 'Phone number is required.',
            'phone.unique'                  => 'Phone number already exists.',

            'password.required'             => 'Password is required.',
            'password.min'                  => 'Password must be at least 6 characters.',
            'password.confirmed'            => 'Password confirmation does not match.',

            'shop_name.required'            => 'Shop name is required.',

            'nid_number.required'           => 'NID number is required.',
            'nid_number.unique'             => 'This NID number is already registered.',

            'nid_front.image'               => 'NID Front must be an image.',
            'nid_back.image'                => 'NID Back must be an image.',
            'selfie_photo.image'            => 'Selfie must be an image.',

            'tin_file.mimes'                => 'TIN file must be JPG, PNG or PDF.',
            'bin_file.mimes'                => 'BIN file must be JPG, PNG or PDF.',
            'cancelled_cheque.mimes'        => 'Cancelled cheque must be JPG, PNG or PDF.',

        ];
    }
}
