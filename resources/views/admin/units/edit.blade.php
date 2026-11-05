@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Edit Unit</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('units.index') }}">All Units</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Unit</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->
    <section class="content">

        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Edit Unit</h3>
            </div>

            <form action="{{ route('units.update', $unit->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card-body">

                    <div class="row">

                        {{-- Unit Name --}}
                        <div class="col-md-12 mb-3">

                            <div class="form-group">

                                <label for="unit_name">
                                    Unit Name <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="unit_name"
                                       id="unit_name"
                                       class="form-control @error('unit_name') is-invalid @enderror"
                                       value="{{ old('unit_name', $unit->unit_name) }}"
                                       placeholder="Enter Unit Name"
                                       required>

                                @error('unit_name')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="col-md-12">

                            <button type="submit" class="btn btn-success">
                                Save Changes
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </section>

</div>

@endsection