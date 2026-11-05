@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Add Variant</h1>
        </div>
    </div>

    <section class="content">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Add Variant</h3>
            </div>

            <form action="{{ route('variants.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- Variant Name --}}
                    <div class="form-group">
                        <label>Variant Name <span class="required">*</span></label>
                        <input type="text"
                               name="variant_name"
                               class="form-control"
                               placeholder="Enter Variant Name"
                               required>
                        @error('variant_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" class="form-control select2bs4" required>
                            <option value="" selected="" disabled="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>

                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="btn btn-primary">
                        Submit
                    </button>

                </div>

            </form>

        </div>

    </section>

</div>

@endsection