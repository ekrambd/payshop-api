@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Edit Variant</h1>
        </div>
    </div>

    <section class="content">

        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Edit Variant</h3>
            </div>

            <form action="{{ route('variants.update', $variant->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card-body">

                    {{-- Variant Name --}}
                    <div class="form-group">
                        <label>Variant Name</label>
                        <input type="text"
                               name="variant_name"
                               class="form-control"
                               value="{{ old('variant_name', $variant->variant_name) }}"
                               required>

                        @error('variant_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" class="form-control select2bs4" required>

                            <option value="Active"
                                {{ $variant->status == 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Inactive"
                                {{ $variant->status == 'Inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="btn btn-success">
                        Update
                    </button>

                </div>

            </form>

        </div>

    </section>

</div>

@endsection