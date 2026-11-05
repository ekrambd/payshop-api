```blade
@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Role Management</h1>
                </div>

                <div class="col-sm-6 text-right">

                    <a href="{{ url('/add-role') }}" class="btn btn-primary">

                        <i class="fas fa-plus"></i>

                        Add New Role

                    </a>

                </div>

            </div>

        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        Role List

                    </h3>

                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped" id="roleTable">

                        <thead>

                        <tr>

                            <th width="70">SL</th>

                            <th>Role Name</th>


                            <th width="150">Action</th>

                        </tr>

                        </thead>

                    </table>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection


@push('scripts')

<script>

$(function () {

    $('#roleTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ url('/role-lists') }}",

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {
                data: 'role_name',
                name: 'role_name'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });



    $(document).on('click','.delete-role',function(e){

        e.preventDefault();

        if(confirm('Are you sure?')){

            let id=$(this).data('id');

            $.ajax({

                url:"{{ url('/delete-role') }}",

                type:"POST",

                data:{
                    id:id,
                    _token:"{{ csrf_token() }}"
                },

                success:function(data){

                    toastr.success(data.message);

                    $('#roleTable').DataTable().ajax.reload(null,false);

                }

            });

        }

    });

});

</script>

@endpush
```
