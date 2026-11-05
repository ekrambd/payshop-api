@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <section class="content">
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Add Unit</h3>
            </div>

            <form method="POST" action="{{ route('units.store') }}">
                @csrf

                <div class="card-body">

                    <input type="text"
                           name="unit_name"
                           class="form-control"
                           placeholder="Unit Name"
                           required>

                    <button class="btn btn-primary mt-2">
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </section>

</div>

@endsection