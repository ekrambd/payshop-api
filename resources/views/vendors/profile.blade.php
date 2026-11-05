@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Edit Vendor</h1>
        </div>
    </div>

    <section class="content">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Edit Vendor</h3>
            </div>

            <form action="{{ url('vendor-profile-update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    <div class="row">

                        {{-- User Information --}}
                        <div class="col-md-12">
                            <h4 class="mb-3 text-primary">User Information</h4>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name',$vendor->user->name) }}"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email',$vendor->user->email) }}"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone',$vendor->user->phone) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file"
                                       name="image"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->user->image) }}">
                            </div>
                        </div>

                        {{-- Shop Information --}}
                        <div class="col-md-12">
                            <hr>
                            <h4 class="mb-3 text-primary">Shop Information</h4>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shop Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="shop_name"
                                       class="form-control"
                                       value="{{ old('shop_name',$vendor->shop_name) }}"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NID Number <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="nid_number"
                                       class="form-control"
                                       value="{{ old('nid_number',$vendor->nid_number) }}"
                                       required>
                            </div>
                        </div>

                        {{-- NID --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NID Front</label>
                                <input type="file"
                                       name="nid_front"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->nid_front) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NID Back</label>
                                <input type="file"
                                       name="nid_back"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->nid_back) }}">
                            </div>
                        </div>

                        {{-- Selfie --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selfie Photo</label>
                                <input type="file"
                                       name="selfie_photo"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->selfie_photo) }}">
                            </div>
                        </div>

                        {{-- Trade License --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trade License No</label>
                                <input type="text"
                                       name="trade_license_no"
                                       class="form-control"
                                       value="{{ old('trade_license_no',$vendor->trade_license_no) }}">
                            </div>
                        </div>

                        {{-- TIN --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TIN No</label>
                                <input type="text"
                                       name="tin_no"
                                       class="form-control"
                                       value="{{ old('tin_no',$vendor->tin_no) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TIN File</label>
                                <input type="file"
                                       name="tin_file"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->tin_file) }}">
                            </div>
                        </div>

                        {{-- BIN --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BIN No</label>
                                <input type="text"
                                       name="bin_no"
                                       class="form-control"
                                       value="{{ old('bin_no',$vendor->bin_no) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BIN File</label>
                                <input type="file"
                                       name="bin_file"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->bin_file) }}">
                            </div>
                        </div>

                        {{-- Bank --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text"
                                       name="bank_name"
                                       class="form-control"
                                       value="{{ old('bank_name',$vendor->bank_name) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch Name</label>
                                <input type="text"
                                       name="branch_name"
                                       class="form-control"
                                       value="{{ old('branch_name',$vendor->branch_name) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Name</label>
                                <input type="text"
                                       name="account_name"
                                       class="form-control"
                                       value="{{ old('account_name',$vendor->account_name) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text"
                                       name="account_number"
                                       class="form-control"
                                       value="{{ old('account_number',$vendor->account_number) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cancelled Cheque</label>
                                <input type="file"
                                       name="cancelled_cheque"
                                       class="form-control dropify"
                                       data-default-file="{{ asset($vendor->cancelled_cheque) }}">
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pickup Address</label>
                                <textarea name="pickup_address"
                                          class="form-control"
                                          rows="4">{{ old('pickup_address',$vendor->pickup_address) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Return Address</label>
                                <textarea name="return_address"
                                          class="form-control"
                                          rows="4">{{ old('return_address',$vendor->return_address) }}</textarea>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer">
                    <button class="btn btn-primary">
                        Update Vendor
                    </button>
                </div>

            </form>

        </div>

    </section>

</div>

@endsection