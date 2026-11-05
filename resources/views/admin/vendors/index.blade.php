@extends('admin_master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Vendor</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Vendor</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Vendor</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control select2bs4" id="status" name="status">
                          <option value="" selected disabled>Select Status</option>
                          <option value="Active">Active</option>
                          <option value="Inactive">Inactive</option>
                      </select>
                  </div>
                </div>

                <div class="col-12">
                 <div class="col-md-12 d-flex justify-content-center button-product-filters">
                    <button type="button" class="btn btn-primary filter-vendor">
                        <i class="fa fa-search"></i> Search
                    </button>

                    <button type="button" class="btn btn-danger reset-filter">
                        Reset
                    </button>
                </div>
                </div>
              </div>

                <div class="fetch-data table-responsive">
                    <table id="vendor-table" class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Shop Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="conts"> 
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
  
  <script>
  	$(document).ready(function(){
  		let vendor_id;
  		var vendorTable = $('#vendor-table').DataTable({
		        searching: true,
		        processing: true,
		        serverSide: true,
		        ordering: false,
		        responsive: true,
		        stateSave: true,
		        ajax: {
		          url: "{{url('/vendor-lists')}}",
              data: function (d) {
                  d.status = $('#status').val(),
                  d.search = $('.dataTables_filter input').val()
             }
		        },

		        columns: [
		            {data: 'name', name: 'name'},
		            {data: 'shop_name', name: 'shop_name'},
		            {data: 'email', name: 'email'},
		            {data: 'phone', name: 'phone'},
		            {data: 'status', name: 'status'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
        });

        $('.filter-vendor').click(function(e){
            e.preventDefault();
            vendorTable.draw(); 
        });

       $(document).on('click', '#status-vendor-update', function(){

	        vendor_id = $(this).data('id');
	        var isVendorchecked = $(this).prop('checked');
	        var status_val = isVendorchecked ? 'Active' : 'Inactive'; 
	        $.ajax({

                url: "{{url('/vendor-status-update')}}",

                     type:"POST",
                     data:{'vendor_id':vendor_id, 'status':status_val},
                     dataType:"json",
                     success:function(data) {

                        toastr.success(data.message);

                        $('.data-table').DataTable().ajax.reload(null, false);

                },
	                            
	        });
       }); 


       $(document).on('click', '.delete-vendor', function(e){

           e.preventDefault();

           vendor_id = $(this).data('id');

           if(confirm('Do you want to delete this?'))
           {
               $.ajax({

                    url: "{{url('/delete-vendor')}}/"+vendor_id,

                         type:"GET",
                         dataType:"json",
                         success:function(data) {

                            toastr.success(data.message);

                            $('.data-table').DataTable().ajax.reload(null, false);

                    },
                                
              });
           }

       });

  	});
  </script>

@endpush