@extends('admin_master')

@section('content')

<div class="content-wrapper">

<div class="content-header">
    <div class="container-fluid">
        <h1>All Subcategories</h1>
    </div>
</div>

<section class="content">

<div class="card">

<div class="card-header">
    <a href="{{route('subcategories.create')}}"
       class="btn btn-primary float-right">
        Add Subcategory
    </a>
</div>

<div class="card-body">

<table class="table table-bordered ytable">

<thead>
<tr>
    <th>SL</th>
    <th>Category</th>
    <th>Subcategory Name</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

</table>

</div>
</div>
</section>
</div>

@endsection


@push('scripts')

<script>

$('.ytable').DataTable({

    processing:true,
    serverSide:true,

    ajax:"{{ route('subcategories.index') }}",

    columns:[
        {data:'DT_RowIndex',name:'DT_RowIndex'},
        {data:'category',name:'category'},
        {data:'subcategory_name',name:'subcategory_name'},
        {data:'status',name:'status'},
        {data:'action',name:'action'}
    ]

});


// ================= DELETE SUBCATEGORY =================

$(document).on('click','.delete-subcategory',function(e){

    e.preventDefault();

    let id = $(this).data('id');

    if(confirm('Do you want to delete this subcategory?')){

        $.ajax({

            url:"{{ url('/subcategories') }}/"+id,
            type:"DELETE",

            data:{
                _token:"{{ csrf_token() }}"
            },

            success:function(data){

                if(data.status){

                    toastr.success(data.message);

                    $('.ytable').DataTable().ajax.reload();

                }

            }

        });

    }

});



// ================= STATUS CHANGE =================

$(document).on('change','#status-subcategory-update',function(){

    let id = $(this).data('id');

    let status = $(this).prop('checked')
        ? 'Active'
        : 'Inactive';

    $.ajax({

        url:"{{ url('/subcategory-status-change') }}",
        type:"POST",

        data:{
            _token:"{{ csrf_token() }}",
            id:id,
            status:status
        },

        success:function(data){

            if(data.status){

                toastr.success('Status updated successfully');

            }

        }

    });

});

</script>

@endpush