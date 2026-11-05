<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vendor Registration</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-10">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3 class="mb-0">
Vendor Registration
</h3>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif


@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif


@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif


<form method="POST"
      action="{{ url('/save-vendor') }}"
      enctype="multipart/form-data">

@csrf


<div class="card mb-4">

<div class="card-header">

<h5 class="mb-0">

Account Information

</h5>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>

Full Name
<span class="text-danger">*</span>

</label>

<input type="text"
       class="form-control"
       name="name"
       value="{{ old('name') }}"
       placeholder="Full Name">

</div>

</div>


<div class="col-md-6">

<div class="form-group">

<label>

Email
<span class="text-danger">*</span>

</label>

<input type="email"
       class="form-control"
       name="email"
       value="{{ old('email') }}"
       placeholder="Email Address">

</div>

</div>


<div class="col-md-6">

<div class="form-group">

<label>

Phone
<span class="text-danger">*</span>

</label>

<input type="text"
       class="form-control"
       name="phone"
       value="{{ old('phone') }}"
       placeholder="Phone Number">

</div>

</div>


<div class="col-md-6">

<div class="form-group">

<label>

Shop Name
<span class="text-danger">*</span>

</label>

<input type="text"
       class="form-control"
       name="shop_name"
       value="{{ old('shop_name') }}"
       placeholder="Shop Name">

</div>

</div>


<div class="col-md-6">

<div class="form-group">

<label>

District


</label>

<input type="text"
       class="form-control"
       name="district"
       value="{{ old('district') }}"
       placeholder="District">

</div>

</div>



<div class="col-md-6">

<div class="form-group">

<label>

Routing Number


</label>

<input type="text"
       class="form-control"
       name="routing_number"
       value="{{ old('routing_number') }}"
       placeholder="District">

</div>

</div>

</div>

</div>

</div>



<div class="card mb-4">

<div class="card-header">

<h5 class="mb-0">

NID Information

</h5>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>

NID Number
<span class="text-danger">*</span>

</label>

<input type="text"
       class="form-control"
       name="nid_number"
       value="{{ old('nid_number') }}"
       placeholder="National ID Number">

</div>

</div>



<div class="col-md-6">

<div class="form-group">

<label>

NID Front <span class="text-danger">*</span>

</label>

<input type="file"
       class="form-control"
       name="nid_front" required>

</div>

</div>



<div class="col-md-6">

<div class="form-group">

<label>

NID Back <span class="text-danger">*</span>

</label>

<input type="file"
       class="form-control"
       name="nid_back" required>

</div>

</div>



<div class="col-md-6">

<div class="form-group">

<label>

Selfie Photo <span class="text-danger">*</span>

</label>

<input type="file"
       class="form-control"
       name="selfie_photo" required>

</div>

</div>


{{-- ================= TRADE LICENSE ================= --}}

<div class="card mb-4" style="width: 100%;">

    <div class="card-header">
        <h5 class="mb-0">Trade License Information</h5>
    </div>

    <div class="card-body" style="width: 100%;">

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">

                    <label>Trade License Number</label>

                    <input type="text"
                           class="form-control"
                           name="trade_license_no"
                           value="{{ old('trade_license_no') }}"
                           placeholder="Trade License Number">

                </div>

            </div>
            
            
            <div class="col-md-12">

                <div class="form-group">

                    <label>Trade License Photo</label>

                    <input type="file"
                           class="form-control"
                           name="trade_file">

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================= TIN ================= --}}

<div class="card mb-4" style="width: 100%;">

    <div class="card-header">
        <h5 class="mb-0">TIN Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>TIN Number</label>

                    <input type="text"
                           class="form-control"
                           name="tin_no"
                           value="{{ old('tin_no') }}"
                           placeholder="TIN Number">

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>TIN File</label>

                    <input type="file"
                           class="form-control"
                           name="tin_file">

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ================= BIN ================= --}}

<div class="card mb-4">

    <div class="card-header">
        <h5 class="mb-0">BIN Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>BIN Number</label>

                    <input type="text"
                           class="form-control"
                           name="bin_no"
                           value="{{ old('bin_no') }}"
                           placeholder="BIN Number">

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>BIN File</label>

                    <input type="file"
                           class="form-control"
                           name="bin_file">

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ================= BANK INFORMATION ================= --}}

<div class="card mb-4">

    <div class="card-header">
        <h5 class="mb-0">Bank Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>Bank Name</label>

                    <input type="text"
                           class="form-control"
                           name="bank_name"
                           value="{{ old('bank_name') }}"
                           placeholder="Bank Name">

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>Branch Name</label>

                    <input type="text"
                           class="form-control"
                           name="branch_name"
                           value="{{ old('branch_name') }}"
                           placeholder="Branch Name">

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>Account Name</label>

                    <input type="text"
                           class="form-control"
                           name="account_name"
                           value="{{ old('account_name') }}"
                           placeholder="Account Holder Name">

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>Account Number</label>

                    <input type="text"
                           class="form-control"
                           name="account_number"
                           value="{{ old('account_number') }}"
                           placeholder="Account Number">

                </div>

            </div>

            <div class="col-md-12">

                <div class="form-group">

                    <label>Cancelled Cheque</label>

                    <input type="file"
                           class="form-control"
                           name="cancelled_cheque">

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ================= ADDRESS INFORMATION ================= --}}

<div class="card mb-4" style="width: 100%">

    <div class="card-header">
        <h5 class="mb-0">Address Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>Pickup Address</label>

                    <textarea
                        name="pickup_address"
                        rows="4"
                        class="form-control"
                        placeholder="Enter Pickup Address">{{ old('pickup_address') }}</textarea>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>Return Address</label>

                    <textarea
                        name="return_address"
                        rows="4"
                        class="form-control"
                        placeholder="Enter Return Address">{{ old('return_address') }}</textarea>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================= PASSWORD ================= --}}

<div class="card mb-4" style="width: 100%">

    <div class="card-header">
        <h5 class="mb-0">Security Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>
                        Password
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter Password"
                        required>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>
                        Confirm Password
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm Password"
                        required>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================= SUBMIT ================= --}}

<div class="text-center mb-3">

    <button
        type="submit"
        class="btn btn-primary btn-lg px-5">

        <i class="fa fa-user-plus"></i>

        Register as Vendor

    </button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>

</html>


</div>

</div>

</div>