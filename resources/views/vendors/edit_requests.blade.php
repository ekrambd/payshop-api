@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-6">
                    <h3>Vendor Edit Requests</h3>
                </div>

            </div>

        </div>
    </div>

    <section class="content">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    All Vendor Edit Requests
                </h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped ytable" id="vendor-request-table">

                    <thead>

                        <tr>

                            <th>SL</th>
                            <th>Vendor</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Status</th>
                            <th>Change Status</th>
                            <th width="120">Action</th>

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

$('#vendor-request-table').DataTable({

    processing:true,
    serverSide:true,

    ajax:"{{ url('/vendor-edit-requests') }}",

    columns:[

        {
            data:'DT_RowIndex',
            name:'DT_RowIndex'
        },

        {
            data:'vendor',
            name:'vendor'
        },

        {
            data:'field_name',
            name:'field_name'
        },

        {
            data:'old_value',
            name:'old_value'
        },

        {
            data:'new_value',
            name:'new_value'
        },

        {
            data:'status',
            name:'status'
        },

        {
            data:'change_status',
            name:'change_status'
        },
        

        {
            data:'action',
            name:'action',
            orderable:false,
            searchable:false
        }

    ]

});

</script>

@endpush