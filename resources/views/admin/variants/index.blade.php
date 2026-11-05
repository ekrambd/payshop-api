@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>All Variants</h1>
        </div>
    </div>

    <section class="content">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Variant List</h3>
            </div>

            <div class="card-body">

                <a href="{{ route('variants.create') }}"
                   class="btn btn-primary float-right mb-2">
                    Add New Variant
                </a>

                <table id="variant-table" class="table table-bordered">

                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Variant Name</th>
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

$(document).ready(function () {

    let table = $('#variant-table').DataTable({
        searching: true,
        processing: true,
        serverSide: true,
        ajax: "{{ url('/variants') }}",
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'variant_name' },
            { data: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Delete
    $(document).on('click', '.delete-variant', function () {

        let id = $(this).data('id');

        if (confirm('Are you sure?')) {

            $.ajax({
                url: "/variants/" + id,
                type: "DELETE",
                success: function (res) {

                    toastr.success(res.message);

                    table.ajax.reload(null, false);
                }
            });

        }

    });

});

</script>

@endpush