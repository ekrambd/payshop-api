@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>All Vendor Products</h1>
        </div>
    </div>

    <section class="content">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">All Vendor Products</h3>
            </div>

            <div class="card-body">

               <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="vendor_id">Vendor</label>
                        <select class="form-control select2bs4" id="vendor_id" name="vendor_id">
                            <option value="" selected disabled>Select Vendor</option>
                            @foreach(vendors() as $vendor)
                             <option value="{{$vendor->id}}">{{$vendor->name}} = {{$vendor->phone}} = {{$vendor->email}}</option>
                            @endforeach 
                        </select>
                    </div>
                 </div>


                 <!-- Status -->
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="admin_verify">Admin Verify</label>
                            <select class="form-control select2bs4" id="admin_verify" name="admin_verify">
                                <option value="" selected disabled>Select Admin Verify</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>


                 <div class="col-12">
                    <div class="col-md-12 d-flex justify-content-center button-product-filters">
                        <button type="button" class="btn btn-primary filter-vendor-product">
                            <i class="fa fa-search"></i> Search
                        </button>

                        <button type="button" class="btn btn-danger reset-filter">
                            Reset
                        </button>
                    </div>
                  </div> 
               </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped data-table" id="vendor-product-table">

                        <thead>
                            <tr>
                            	<th>Vendor Name</th>
                            	<th>Vendor Phone</th>
                            	<th>Vendor Shop</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Discount (%)</th>
                                <th>Stock</th>
                                <th>Is Verify</th>
                                <th>Status</th>
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

    let vendorProductTable = $('#vendor-product-table').DataTable({
        searching: true,
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{url('/vendor-products')}}",
          data: function (d) {

                d.vendor_id = $('#vendor_id').val(),
                d.status = $('#status').val(),
                d.admin_verify = $('#admin_verify').val(),
                d.search = $('.dataTables_filter input').val()
           }
        },
        ordering: false,
        responsive: true,
        stateSave: true,

        columns: [
            { data: 'vendor_name', name: 'vendor_name' },
            { data: 'vendor_phone', name: 'vendor_phone' },
            { data: 'vendor_shop', name: 'vendor_shop' },
            { data: 'image', name: 'image' },
            { data: 'product_name', name: 'product_name' },
            { data: 'category', name: 'category' },
            { data: 'unit', name: 'unit' },
            { data: 'product_price', name: 'product_price' },
            { data: 'product_discount', name: 'product_discount' },
            { data: 'stock_qty', name: 'stock_qty' },
            { data: 'admin_verify', name: 'admin_verify' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('.filter-vendor-product').click(function(e){
        e.preventDefault();
        vendorProductTable.draw(); 
    });


    // STATUS TOGGLE
    $(document).on('click', '#status-product-verify', function () {

        let product_id = $(this).data('id');
        let status = $(this).prop('checked') ? 'Yes' : 'No';

        $.ajax({
            url: "{{ url('/product-status-verify') }}",
            type: "POST",
            data: {
                product_id: product_id,
                admiVerify: status,
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


    // STATUS TOGGLE
    $(document).on('click', '#status-product-admin-update', function () {

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

});
</script>

@endpush