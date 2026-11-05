```blade
@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Edit Role</h1>
        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <form action="{{ url('/update-role/'.$role->id) }}" method="POST">

                @csrf

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Role Information</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">

                            <label>Role Name</label>

                            <input type="text"
                                   name="role_name"
                                   class="form-control"
                                   value="{{ $role->role_name }}"
                                   required>

                        </div>

                    </div>

                </div>

                <!-- ================= Slider ================= -->

                <div class="card card-info">

                    <div class="card-header">
                        <h3 class="card-title">Slider Permission</h3>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="slider_add"
                                           value="Yes"
                                           {{ $permission->slider_add=='Yes'?'checked':'' }}>
                                    Add
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="slider_edit"
                                           value="Yes"
                                           {{ $permission->slider_edit=='Yes'?'checked':'' }}>
                                    Edit
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="slider_lists"
                                           value="Yes"
                                           {{ $permission->slider_lists=='Yes'?'checked':'' }}>
                                    Lists
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="slider_delete"
                                           value="Yes"
                                           {{ $permission->slider_delete=='Yes'?'checked':'' }}>
                                    Delete
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label>
                                    <input type="checkbox"
                                           name="slider_status_update"
                                           value="Yes"
                                           {{ $permission->slider_status_update=='Yes'?'checked':'' }}>
                                    Status Update
                                </label>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- ================= Category ================= -->

                <div class="card card-success">

                    <div class="card-header">
                        <h3 class="card-title">Category Permission</h3>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="category_add"
                                           value="Yes"
                                           {{ $permission->category_add=='Yes'?'checked':'' }}>
                                    Add
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="category_edit"
                                           value="Yes"
                                           {{ $permission->category_edit=='Yes'?'checked':'' }}>
                                    Edit
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="category_lists"
                                           value="Yes"
                                           {{ $permission->category_lists=='Yes'?'checked':'' }}>
                                    Lists
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="category_delete"
                                           value="Yes"
                                           {{ $permission->category_delete=='Yes'?'checked':'' }}>
                                    Delete
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label>
                                    <input type="checkbox"
                                           name="category_status_update"
                                           value="Yes"
                                           {{ $permission->category_status_update=='Yes'?'checked':'' }}>
                                    Status Update
                                </label>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- ================= Sub Category ================= -->

                <div class="card card-warning">

                    <div class="card-header">
                        <h3 class="card-title">Sub Category Permission</h3>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="subcategory_add"
                                           value="Yes"
                                           {{ $permission->subcategory_add=='Yes'?'checked':'' }}>
                                    Add
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="subcategory_edit"
                                           value="Yes"
                                           {{ $permission->subcategory_edit=='Yes'?'checked':'' }}>
                                    Edit
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="subcategory_lists"
                                           value="Yes"
                                           {{ $permission->subcategory_lists=='Yes'?'checked':'' }}>
                                    Lists
                                </label>
                            </div>

                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox"
                                           name="subcategory_delete"
                                           value="Yes"
                                           {{ $permission->subcategory_delete=='Yes'?'checked':'' }}>
                                    Delete
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label>
                                    <input type="checkbox"
                                           name="subcategory_status_update"
                                           value="Yes"
                                           {{ $permission->subcategory_status_update=='Yes'?'checked':'' }}>
                                    Status Update
                                </label>
                            </div>

                        </div>

                    </div>

                </div>

{{-- Category Permission --}}

<div class="card mt-4">

    <div class="card-header bg-success">

        <h5 class="mb-0 text-white">
            Category Permission
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-2">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="category_add"
                           value="Yes"
                           id="category_add"
                           {{ $permission->category_add == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="category_add">

                        Add

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="category_edit"
                           value="Yes"
                           id="category_edit"
                           {{ $permission->category_edit == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="category_edit">

                        Edit

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="category_lists"
                           value="Yes"
                           id="category_lists"
                           {{ $permission->category_lists == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="category_lists">

                        List

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="category_delete"
                           value="Yes"
                           id="category_delete"
                           {{ $permission->category_delete == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="category_delete">

                        Delete

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="category_status_update"
                           value="Yes"
                           id="category_status_update"
                           {{ $permission->category_status_update == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="category_status_update">

                        Status Update

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===========================
    Subcategory Permission
=========================== --}}

<div class="card mt-4">

    <div class="card-header bg-warning">

        <h5 class="mb-0 text-dark">
            Subcategory Permission
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="subcategory_add"
                           name="subcategory_add"
                           value="Yes"
                           {{ $permission->subcategory_add == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="subcategory_add">

                        Add

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="subcategory_edit"
                           name="subcategory_edit"
                           value="Yes"
                           {{ $permission->subcategory_edit == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="subcategory_edit">

                        Edit

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="subcategory_lists"
                           name="subcategory_lists"
                           value="Yes"
                           {{ $permission->subcategory_lists == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="subcategory_lists">

                        List

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="subcategory_delete"
                           name="subcategory_delete"
                           value="Yes"
                           {{ $permission->subcategory_delete == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="subcategory_delete">

                        Delete

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="subcategory_status_update"
                           name="subcategory_status_update"
                           value="Yes"
                           {{ $permission->subcategory_status_update == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="subcategory_status_update">

                        Status Update

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===========================
    Unit Permission
=========================== --}}

<div class="card mt-4">

    <div class="card-header bg-info">

        <h5 class="mb-0 text-white">
            Unit Permission
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="unit_add"
                           name="unit_add"
                           value="Yes"
                           {{ $permission->unit_add == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="unit_add">

                        Add

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="unit_edit"
                           name="unit_edit"
                           value="Yes"
                           {{ $permission->unit_edit == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="unit_edit">

                        Edit

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="unit_lists"
                           name="unit_lists"
                           value="Yes"
                           {{ $permission->unit_lists == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="unit_lists">

                        List

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="unit_delete"
                           name="unit_delete"
                           value="Yes"
                           {{ $permission->unit_delete == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="unit_delete">

                        Delete

                    </label>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="unit_status_update"
                           name="unit_status_update"
                           value="Yes"
                           {{ $permission->unit_status_update == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="unit_status_update">

                        Status Update

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===========================
    Variant Permission
=========================== --}}

<div class="card mt-4">

    <div class="card-header bg-secondary">

        <h5 class="mb-0 text-white">
            Variant Permission
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="variant_add"
                           name="variant_add"
                           value="Yes"
                           {{ $permission->variant_add == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="variant_add">

                        Add

                    </label>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="vairant_edit"
                           name="vairant_edit"
                           value="Yes"
                           {{ $permission->vairant_edit == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="vairant_edit">

                        Edit

                    </label>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="variant_lists"
                           name="variant_lists"
                           value="Yes"
                           {{ $permission->variant_lists == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="variant_lists">

                        List

                    </label>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="variant_delete"
                           name="variant_delete"
                           value="Yes"
                           {{ $permission->variant_delete == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="variant_delete">

                        Delete

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===========================
    Vendor Permission
=========================== --}}

<div class="card mt-4">

    <div class="card-header bg-danger">

        <h5 class="mb-0 text-white">
            Vendor Permission
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="vendor_lists"
                           name="vendor_lists"
                           value="Yes"
                           {{ $permission->vendor_lists == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="vendor_lists">

                        Vendor Lists

                    </label>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="vendor_product_verify"
                           name="vendor_product_verify"
                           value="Yes"
                           {{ $permission->vendor_product_verify == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="vendor_product_verify">

                        Vendor Product Verify

                    </label>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="vendor_product_status_change"
                           name="vendor_product_status_change"
                           value="Yes"
                           {{ $permission->vendor_product_status_change == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="vendor_product_status_change">

                        Vendor Product Status Change

                    </label>

                </div>

            </div>

            <div class="col-md-6 mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="vendor_product_lists"
                           name="vendor_product_lists"
                           value="Yes"
                           {{ $permission->vendor_product_lists == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="vendor_product_lists">

                        Vendor Product Lists

                    </label>

                </div>

            </div>

            <div class="col-md-6 mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           class="form-check-input"
                           id="vendor_edit_requests"
                           name="vendor_edit_requests"
                           value="Yes"
                           {{ $permission->vendor_edit_requests == 'Yes' ? 'checked' : '' }}>

                    <label class="form-check-label" for="vendor_edit_requests">

                        Vendor Edit Requests

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card-footer text-right">

    <button type="submit" class="btn btn-success">

        <i class="fa fa-save"></i>

        Update Role Permission

    </button>

    <a href="{{ url('/role-lists') }}" class="btn btn-secondary">

        Back

    </a>

</div>

</form>

</div>

</section>

</div>

@endsection
