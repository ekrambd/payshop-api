@extends('admin_master')

@section('content')

<div class="content-wrapper">

<div class="content-header">
    <div class="container-fluid">
        <h1>Add Subcategory</h1>
    </div>
</div>

<section class="content">

<div class="card card-primary">

<div class="card-header">
    <h3 class="card-title">Add Subcategory</h3>
</div>

<form action="{{route('subcategories.store')}}" method="POST">
@csrf

<div class="card-body">

<div class="form-group">
    <label for="category_id">
        Category <span class="text-danger">*</span>
    </label>

    <select name="category_id"
            id="category_id"
            class="form-control select2bs4"
            required>

        <option value="" disabled selected>Select Category</option>

        @foreach(categories() as $category)
            <option value="{{$category->id}}">
                {{$category->category_name}}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <span class="invalid-feedback d-block">{{$message}}</span>
    @enderror
</div>


<div class="form-group">
    <label for="subcategory_name">
        Subcategory Name <span class="text-danger">*</span>
    </label>

    <input type="text"
           name="subcategory_name"
           id="subcategory_name"
           class="form-control"
           placeholder="Enter subcategory name"
           value="{{old('subcategory_name')}}"
           required>

    @error('subcategory_name')
        <span class="invalid-feedback d-block">{{$message}}</span>
    @enderror
</div>


<div class="form-group">
    <label for="status">
        Select Status <span class="text-danger">*</span>
    </label>

    <select name="status"
            id="status"
            class="form-control select2bs4"
            required>

        <option value="" disabled selected>Select Status</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>

    </select>

    @error('status')
        <span class="invalid-feedback d-block">{{$message}}</span>
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