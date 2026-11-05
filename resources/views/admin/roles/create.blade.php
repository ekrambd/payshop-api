@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Create Role</h1>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{ url('/roles') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                </div>

            </div>

        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <form action="{{ url('/save-role') }}" method="POST">

                @csrf

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">
                            Role Information
                        </h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">

                            <label>
                                Role Name
                            </label>

                            <input type="text"
                                   name="role_name"
                                   class="form-control"
                                   placeholder="Enter Role Name"
                                   required>

                        </div>

                        <hr>

<h4 class="mb-3">
    Slider Permissions
</h4>

<div class="row">

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="slider_add">

            <label class="form-check-label">
                Add
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="slider_edit">

            <label class="form-check-label">
                Edit
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="slider_lists">

            <label class="form-check-label">
                List
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="slider_delete">

            <label class="form-check-label">
                Delete
            </label>
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="slider_status_update">

            <label class="form-check-label">
                Status Update
            </label>
        </div>

    </div>

</div>

<hr>

<h4 class="mb-3">
    Category Permissions
</h4>

<div class="row">

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="category_add"
                   id="category_add">

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
                   id="category_edit">

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
                   id="category_lists">

            <label class="form-check-label" for="category_lists">
                Lists
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="category_delete"
                   id="category_delete">

            <label class="form-check-label" for="category_delete">
                Delete
            </label>
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="category_status_update"
                   id="category_status_update">

            <label class="form-check-label" for="category_status_update">
                Status Update
            </label>
        </div>

    </div>

</div>

<hr>

<h4 class="mb-3">
    Subcategory Permissions
</h4>

<div class="row">

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="subcategory_add"
                   id="subcategory_add">

            <label class="form-check-label" for="subcategory_add">
                Add
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="subcategory_edit"
                   id="subcategory_edit">

            <label class="form-check-label" for="subcategory_edit">
                Edit
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="subcategory_lists"
                   id="subcategory_lists">

            <label class="form-check-label" for="subcategory_lists">
                Lists
            </label>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="subcategory_delete"
                   id="subcategory_delete">

            <label class="form-check-label" for="subcategory_delete">
                Delete
            </label>
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="subcategory_status_update"
                   id="subcategory_status_update">

            <label class="form-check-label" for="subcategory_status_update">
                Status Update
            </label>
        </div>

    </div>

</div>

<hr>

<h4 class="mb-3">
    Unit Permissions
</h4>

<div class="row">

    <div class="col-md-2">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="unit_add"
                   name="unit_add">

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
                   name="unit_edit">

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
                   name="unit_lists">

            <label class="form-check-label" for="unit_lists">
                Lists
            </label>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="unit_delete"
                   name="unit_delete">

            <label class="form-check-label" for="unit_delete">
                Delete
            </label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="unit_status_update"
                   name="unit_status_update">

            <label class="form-check-label" for="unit_status_update">
                Status Update
            </label>
        </div>
    </div>

</div>

<hr>

<h4 class="mb-3">
    Variant Permissions
</h4>

<div class="row">

    <div class="col-md-3">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="variant_add"
                   name="variant_add">

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
                   name="vairant_edit">

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
                   name="variant_lists">

            <label class="form-check-label" for="variant_lists">
                Lists
            </label>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="variant_delete"
                   name="variant_delete">

            <label class="form-check-label" for="variant_delete">
                Delete
            </label>
        </div>
    </div>

</div>

<hr>

<h4 class="mb-3">
    Vendor Permissions
</h4>

<div class="row">

    <div class="col-md-4">

        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="vendor_lists"
                   name="vendor_lists">

            <label class="form-check-label" for="vendor_lists">
                Vendor Lists
            </label>
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="vendor_product_verify"
                   name="vendor_product_verify">

            <label class="form-check-label" for="vendor_product_verify">
                Product Verify
            </label>
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="vendor_product_status_change"
                   name="vendor_product_status_change">

            <label class="form-check-label" for="vendor_product_status_change">
                Product Status Change
            </label>
        </div>

    </div>

</div>

<div class="row mt-3">

    <div class="col-md-6">

        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="vendor_product_lists"
                   name="vendor_product_lists">

            <label class="form-check-label" for="vendor_product_lists">
                Vendor Product Lists
            </label>
        </div>

    </div>

    <div class="col-md-6">

        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   id="vendor_edit_requests"
                   name="vendor_edit_requests">

            <label class="form-check-label" for="vendor_edit_requests">
                Vendor Edit Requests
            </label>
        </div>

    </div>

</div>

</div>

<div class="card-footer">

    <button type="submit" class="btn btn-primary">

        <i class="fas fa-save"></i>

        Save Role

    </button>

    <a href="{{ url('/roles') }}" class="btn btn-secondary">

        Cancel

    </a>

</div>

</div>

</form>

</div>

</section>

</div>

@endsection