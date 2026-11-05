@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Slider</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('sliders.index') }}">All Sliders</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Slider</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="card card-success">

            <div class="card-header">
                <h3 class="card-title">Edit Slider</h3>
            </div>

            <form action="{{ route('sliders.update',$slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">

                    

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
                                    data-default-file="{{URL::to($slider->slider_image)}}"
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
                                    <option value="Active" <?php if($slider->status == 'Active'){echo "selected";} ?>>Active</option>
                                    <option value="Inactive" <?php if($slider->status == 'Inactive'){echo "selected";} ?>>Inactive</option>
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