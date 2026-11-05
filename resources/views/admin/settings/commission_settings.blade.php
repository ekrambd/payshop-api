@extends('admin_master')

@section('content')
<div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Commission Settings</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ url('/commission-settings') }}">Commission Settings</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Commission Settings
                        </li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <!-- Main Content -->

    <section class="content">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    Commission Settings
                </h3>

            </div>

            <form action="{{ url('save-commission-fee') }}" method="POST">

                @csrf

                <div class="card-body">

                    <div class="row">

                        {{-- Sell Fee --}}

                        <div class="col-md-12">

                            <div class="form-group">

                                <label>
                                    Sell Fee (%)<span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="sell_fee"
                                       class="form-control numericInput"
                                       value="{{ old('sell_fee',$data->sell_fee) }}"
                                       placeholder="Sell Fee"
                                       required>

                                @error('sell_fee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        
                        {{-- Verify Fee --}}

                        <div class="col-md-12">

                            <div class="form-group">

                                <label>
                                    Verify Fee (%)<span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="verify_fee"
                                       class="form-control numericInput"
                                       value="{{ old('verify_fee',$data->verify_fee) }}"
                                       placeholder="Verify Fee"
                                       required>

                                @error('verify_fee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>

                        {{-- Submit Button --}}

                        <div class="col-md-12">

                            <button class="btn btn-primary">

                                <i class="fas fa-save"></i>

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