@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Category</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('sliders.index') }}">All Sliders</a>
                        </li>
                        <li class="breadcrumb-item active">Add Category</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">Add Category</h3>
            </div>

            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">


                    	{{-- Category Name --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="category_name">
                                    Category Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" name="category_name" id="category_name" required="{{old('category_name')}}" placeholder="Category Name" />

                                @error('category_name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    

                        {{-- Image --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="image">
                                    Image <span class="text-danger">*</span>
                                </label>

                                <input type="file"
                                    name="image"
                                    id="image"
                                    class="form-control dropify @error('image') is-invalid @enderror"
                                    accept="image/*"
                                    data-height="150"
                                    required>

                                @error('image')
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

                                <select name="status" id="status"
                                    class="form-control select2bs4 @error('status') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </section>

</div>
@endsection