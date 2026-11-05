@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <section class="content">

        <div class="card">

            <div class="card-header">
                <h3>All Units</h3>
            </div>

            <div class="card-body">

                <a href="{{ route('units.create') }}" class="btn btn-primary float-right mb-2">
                    Add New Unit
                </a>

                <table id="unit-table" class="table table-bordered">

                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Unit Name</th>
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

$(function () {

    $('#unit-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/units') }}",
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'unit_name'},
            {data: 'action'}
        ]
    });

    $(document).on('click', '.delete-unit', function () {

        let id = $(this).data('id');

        if (confirm('Delete this unit?')) {

            $.ajax({
                url: "/units/" + id,
                type: "DELETE",
                success: function (res) {
                    toastr.success(res.message);
                    $('#unit-table').DataTable().ajax.reload();
                }
            });

        }

    });

});

</script>

@endpush