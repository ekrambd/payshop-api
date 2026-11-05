@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>All Products</h1>
        </div>
    </div>

    <section class="content">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">All Products</h3>
            </div>

            <div class="card-body">

                <div class="row">

                    <!-- From Date -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
                        </div>
                    </div>

                    <!-- To Date -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control select2bs4" id="status" name="status">
                                <option value="" selected disabled>Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>


                    <!-- Admin Verify -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="admin_verify">Admin Verify</label>
                            <select class="form-control select2bs4" id="admin_verify" name="admin_verify">
                                <option value="" selected disabled>Select Admin Verify</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12">
                         <div class="col-md-12 d-flex justify-content-center button-product-filters">
                            <button type="button" class="btn btn-primary filter-product">
                                <i class="fa fa-search"></i> Search
                            </button>

                            <button type="button" class="btn btn-danger reset-filter">
                                Reset
                            </button>
                        </div>
                    </div>

                </div>
                <a href="{{ route('products.create') }}" class="btn btn-primary float-right mb-3">
                    Add New Product
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped data-table" id="product-table">

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Discount (%)</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Admin Verify</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>
                </div>

            </div>

        </div>

    </section>

</div>

@endsection


@push('scripts')

<script>
$(document).ready(function () {

    let productTable = $('#product-table').DataTable({
        searching: true,
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{route('products.index')}}",
          data: function (d) {

                d.from_date = $('#from_date').val(),
                d.to_date = $('#to_date').val(),
                d.status = $('#status').val(),
                d.admin_verify = $('#admin_verify').val(),
                d.search = $('.dataTables_filter input').val()
           }
        },
        ordering: false,
        responsive: true,
        stateSave: true,

        columns: [
            { data: 'image', name: 'image' },
            { data: 'product_name', name: 'product_name' },
            { data: 'category', name: 'category' },
            { data: 'unit', name: 'unit' },
            { data: 'product_price', name: 'product_price' },
            { data: 'product_discount', name: 'product_discount' },
            { data: 'stock_qty', name: 'stock_qty' },
            { data: 'status', name: 'status' },
            { data: 'admin_verify', name: 'admin_verify' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('.filter-product').click(function(e){
            e.preventDefault();
            productTable.draw(); 
    }); 


    // STATUS TOGGLE
    $(document).on('click', '#status-product-update', function () {

        let product_id = $(this).data('id');
        let status = $(this).prop('checked') ? 'Active' : 'Inactive';

        $.ajax({
            url: "{{ url('/product-status-update') }}",
            type: "POST",
            data: {
                product_id: product_id,
                status: status,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                toastr.success(data.message);
                $('.data-table').DataTable().ajax.reload(null, false);
            }
        });
    });


    // DELETE PRODUCT
    $(document).on('click', '.delete-product', function (e) {
        e.preventDefault();

        let product_id = $(this).data('id');

        if (confirm('Do you want to delete this product?')) {

            $.ajax({
                url: "{{ url('/products') }}/" + product_id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    toastr.success(data.message);
                    $('.data-table').DataTable().ajax.reload(null, false);
                }
            });
        }
    });

});
</script>

@endpush