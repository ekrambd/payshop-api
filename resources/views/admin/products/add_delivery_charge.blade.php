@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Product Delivery Charge</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.index') }}">All Products</a>
                        </li>
                        <li class="breadcrumb-item active">Add Product Delivery Charge</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Add Product Delivery Charge</h3>
            </div>

            <form action="{{ url('/save-product-delivery-charge/'.$id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">



                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="inside_base_charge">
                                    Inside City Delivery Charge <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" name="inside_base_charge" id="inside_base_charge" value="{{ old('inside_base_charge', $charge->inside_base_charge ?? '') }}" placeholder="Inside City Delivery Charge" />

                                @error('inside_base_charge')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="outside_delivery_charge">
                                    Outsider City Delivery Charge <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" name="outside_base_charge" id="outside_delivery_charge" value="{{ old('outside_delivery_charge', $charge->outside_base_charge ?? '') }}" placeholder="Outsider City Delivery Charge" />

                                @error('outside_delivery_charge')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="per_weight_charge">
                                    Per Weight Charge <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" name="per_weight_charge" id="per_weight_charge" value="{{ old('per_weight_charge', $charge->per_weight_charge ?? '') }}" placeholder="Outsider City Delivery Charge" />

                                @error('per_weight_charge')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="product_weight">
                                    Product Weight (kg) <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" name="product_weight" id="product_weight" value="{{ old('product_weight', $charge->product_weight ?? '') }}" placeholder="Product Weight (kg)" />

                                @error('product_weight')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> 


                        {{-- Submit --}}
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">
                                Save Changes
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </section>

</div>
@endsection