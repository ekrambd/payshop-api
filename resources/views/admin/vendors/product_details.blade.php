@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Product Details</h1>
        </div>
    </div>

    <section class="content">

        <div class="card card-info">

            <div class="card-header">
                <h3 class="card-title">Product Information</h3>
            </div>

            <div class="card-body">

                {{-- Product Image --}}
                <div class="text-center mb-4">
                    <img src="{{ asset($product->product_image) }}"
                         class="img-thumbnail"
                         style="max-width:250px;">
                </div>

                {{-- Product Name --}}
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->product_name }}"
                           readonly>
                </div>

                {{-- Category --}}
                <div class="form-group">
                    <label>Category</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->category->category_name ?? '' }}"
                           readonly>
                </div>

                {{-- Unit --}}
                <div class="form-group">
                    <label>Unit</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->unit->unit_name ?? '' }}"
                           readonly>
                </div>

                {{-- Price --}}
                <div class="form-group">
                    <label>Price</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->product_price }}"
                           readonly>
                </div>

                {{-- Discount --}}
                <div class="form-group">
                    <label>Discount</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->product_discount }}"
                           readonly>
                </div>

                {{-- Stock --}}
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->stock_qty }}"
                           readonly>
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label>Status</label>

                    @if($product->status == 'Active')
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>Description</label>

                    <div class="border rounded p-3 bg-light">
                        {!! $product->description !!}
                    </div>
                </div>

                {{-- Created At --}}
                <div class="form-group">
                    <label>Created At</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->created_at->format('d M, Y h:i A') }}"
                           readonly>
                </div>

                {{-- Updated At --}}
                <div class="form-group">
                    <label>Last Updated</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $product->updated_at->format('d M, Y h:i A') }}"
                           readonly>
                </div>

                <a href="{{ url('/vendor-products') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                

            </div>

        </div>

    </section>

</div>

@endsection