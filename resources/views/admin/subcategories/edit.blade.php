```blade
@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Subcategory</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('subcategories.index') }}">All Subcategories</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Subcategory</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Edit Subcategory</h3>
            </div>

            <form action="{{ route('subcategories.update',$subcategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">

                        {{-- Category --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">

                                <label for="category_id">
                                    Category <span class="text-danger">*</span>
                                </label>

                                <select name="category_id"
                                        id="category_id"
                                        class="form-control select2bs4 @error('category_id') is-invalid @enderror"
                                        required>

                                    <option value="" disabled>Select Category</option>

                                    @foreach(categories() as $category)

                                        <option value="{{ $category->id }}"
                                            {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>

                                            {{ $category->category_name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        {{-- Subcategory Name --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">

                                <label for="subcategory_name">
                                    Subcategory Name <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       class="form-control @error('subcategory_name') is-invalid @enderror"
                                       name="subcategory_name"
                                       id="subcategory_name"
                                       value="{{ old('subcategory_name',$subcategory->subcategory_name) }}"
                                       placeholder="Enter Subcategory Name"
                                       required>

                                @error('subcategory_name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        {{-- Status --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">

                                <label for="status">
                                    Select Status <span class="text-danger">*</span>
                                </label>

                                <select name="status"
                                        id="status"
                                        class="form-control select2bs4 @error('status') is-invalid @enderror"
                                        required>

                                    <option value="" disabled>Select Status</option>

                                    <option value="Active"
                                        {{ old('status',$subcategory->status)=='Active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="Inactive"
                                        {{ old('status',$subcategory->status)=='Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                                @error('status')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>


                        {{-- Submit --}}
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </section>

</div>

@endsection
```
