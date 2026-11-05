@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Category</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('categories.index') }}">All Sliders</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Category</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
            </div>

            <form action="{{ route('categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">


                    	{{-- Category Name --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="category_name">
                                    Category Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" class="form-control" name="category_name" id="category_name" required="" value="{{old('category_name',$category->category_name)}}" placeholder="Category Name" />

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
                                    data-default-file="{{URL::to($category->category_image)}}">

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
                                    <option value="Active" <?php if($category->status == 'Active'){echo "selected";} ?>>Active</option>
                                    <option value="Inactive" <?php if($category->status == 'Inactive'){echo "selected";} ?>>Inactive</option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
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