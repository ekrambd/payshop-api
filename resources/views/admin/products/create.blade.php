@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Add Product</h1>
        </div>
    </div>

    <section class="content">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Add Product</h3>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    {{-- Product Name --}}
                    <div class="form-group">
                        <label for="product_name">Product Name <span class="required">*</span></label>
                        <input type="text"
                               id="product_name"
                               name="product_name"
                               class="form-control"
                               placeholder="Enter product name"
                               value="{{ old('product_name') }}"
                               required>

                        @error('product_name')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <label for="category_id">Category <span class="required">*</span></label>
                        <select id="category_id" name="category_id" class="form-control select2bs4" required>
                            <option value="" disabled selected>Select category</option>

                            @foreach(categories() as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- SubCategory --}} 
                    <div class="form-group">
                        <label for="subcategory_id">SubCategory</label>
                        <select id="subcategory_id" name="subcategory_id" class="form-control select2bs4">
                            <option value="" disabled selected>Select Subcatory</option>

                            
                        </select>


                        @error('subcategory_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Unit --}}
                    <div class="form-group">
                        <label for="unit_id">Unit <span class="required">*</span></label>
                        <select id="unit_id" name="unit_id" class="form-control select2bs4" required>
                            <option value="" disabled selected>Select unit</option>

                            @foreach(units() as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('unit_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="form-group">
                        <label for="product_price">Price <span class="required">*</span></label>
                        <input type="text"
                               id="product_price"
                               name="product_price"
                               class="form-control"
                               placeholder="Enter product price"
                               value="{{ old('product_price') }}"
                               required>

                        @error('product_price')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Discount --}}

                    <div class="form-group">
                        <label for="discount_amount">Discount Amount</label>
                        <input type="text"
                               id="discount_amount"
                               name="discount_amount"
                               class="form-control numericInput"
                               placeholder="Enter discount Amount"
                               >
                    </div>

                    <div class="form-group">
                        <label for="product_discount">Discount (%)</label>
                        <input type="text"
                               id="product_discount"
                               name="product_discount"
                               class="form-control" readonly="" 
                               placeholder="Enter discount (optional)"
                               value="{{ old('product_discount',0) }}">

                        @error('product_discount')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="form-group">
                        <label for="stock_qty">Stock <span class="required">*</span></label>
                        <input type="number"
                               id="stock_qty"
                               name="stock_qty"
                               class="form-control"
                               placeholder="Enter stock quantity"
                               value="{{ old('stock_qty') }}"
                               required>

                        @error('stock_qty')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea id="description"
                                  name="description"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Enter product description"
                                  required>{{ old('description') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="form-group">
                        <label for="featured_image">Image <span class="required">*</span></label>
                        <input type="file"
                               id="featured_image"
                               name="featured_image"
                               class="form-control dropify"
                               accept="image/*"
                               required>

                        @error('featured_image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    

                    <button class="btn btn-primary">Submit</button>

                </div>
            </form>

        </div>

    </section>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    $(document).on('change', '#category_id', function () {

        let category_id = $(this).val();

        $.ajax({
            url: "{{ url('/subcategories-by-category') }}",
            type: "POST",
            data: {
                category_id: category_id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",

            beforeSend: function () {
                $('#subcategory_id').html('<option selected disabled>Loading...</option>');
            },

            success: function (response) {

                let html = '<option value="" selected disabled>Select SubCategory</option>';

                $.each(response.data, function (index, item) {
                    html += `<option value="${item.id}">${item.subcategory_name}</option>`;
                });

                $('#subcategory_id').html(html);
            },

            error: function (xhr) {
                console.log(xhr.responseText);

                $('#subcategory_id').html(
                    '<option value="" selected disabled>No SubCategory Found</option>'
                );
            }
        });

    });

    $(document).on('input', '#discount_amount', function () {

        let amount = parseFloat($(this).val());
        let price = parseFloat($('#product_price').val());

        if (isNaN(price) || price <= 0) {
            alert('Please fill product price first');
            $(this).val('');
            $('#product_discount').val('');
            return;
        }

        if (isNaN(amount) || amount < 0) {
            $('#product_discount').val('');
            return;
        }

        // Discount amount > Price হলে
        if (amount > price) {
            alert('Discount amount cannot be greater than product price.');
            $(this).val('');
            $('#product_discount').val('');
            return;
        }

        let discountPercent = (amount / price) * 100;

        $('#product_discount').val(discountPercent.toFixed(2));
    });

});
</script>
@endpush