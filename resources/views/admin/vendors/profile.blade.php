@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h1>Vendor Profile</h1>
        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <div class="card">

                <div class="card-header bg-primary">
                    <h3 class="card-title">Vendor Information</h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3 text-center">

                            <img src="{{ asset($user->image) }}"
                                 class="img-thumbnail mb-3"
                                 width="180">

                            <h4>{{ $user->name }}</h4>

                            <p>{{ $user->email }}</p>

                            <p>{{ $user->phone }}</p>

                            <span class="badge badge-success">
                                {{ $user->status }}
                            </span>

                        </div>

                        <div class="col-md-9">

                            <table class="table table-bordered">

                                <tr>
                                    <th width="250">Shop Name</th>
                                    <td>{{ $user->vendor->shop_name }}</td>
                                </tr>

                                <tr>
                                    <th>NID Number</th>
                                    <td>{{ $user->vendor->nid_number }}</td>
                                </tr>

                                <tr>
                                    <th>Trade License No</th>
                                    <td>{{ $user->vendor->trade_license_no }}</td>
                                </tr>

                                <tr>
                                    <th>TIN Number</th>
                                    <td>{{ $user->vendor->tin_no }}</td>
                                </tr>

                                <tr>
                                    <th>BIN Number</th>
                                    <td>{{ $user->vendor->bin_no }}</td>
                                </tr>

                                <tr>
                                    <th>Bank Name</th>
                                    <td>{{ $user->vendor->bank_name }}</td>
                                </tr>

                                <tr>
                                    <th>Branch Name</th>
                                    <td>{{ $user->vendor->branch_name }}</td>
                                </tr>

                                <tr>
                                    <th>Account Name</th>
                                    <td>{{ $user->vendor->account_name }}</td>
                                </tr>

                                <tr>
                                    <th>Account Number</th>
                                    <td>{{ $user->vendor->account_number }}</td>
                                </tr>

                                <tr>
                                    <th>Pickup Address</th>
                                    <td>{{ $user->vendor->pickup_address }}</td>
                                </tr>

                                <tr>
                                    <th>Return Address</th>
                                    <td>{{ $user->vendor->return_address }}</td>
                                </tr>

                            </table>

                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-4 text-center">

                            <h5>NID Front</h5>

                            @if($user->vendor->nid_front)
                                <img src="{{ asset($user->vendor->nid_front) }}"
                                     class="img-fluid img-thumbnail">
                            @endif

                        </div>

                        <div class="col-md-4 text-center">

                            <h5>NID Back</h5>

                            @if($user->vendor->nid_back)
                                <img src="{{ asset($user->vendor->nid_back) }}"
                                     class="img-fluid img-thumbnail">
                            @endif

                        </div>

                        <div class="col-md-4 text-center">

                            <h5>Selfie Photo</h5>

                            @if($user->vendor->selfie_photo)
                                <img src="{{ asset($user->vendor->selfie_photo) }}"
                                     class="img-fluid img-thumbnail">
                            @endif

                        </div>

                    </div>

                    <hr>

                    <div class="row">

    <!-- TIN -->
    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">TIN File</h5>

                @if($user->vendor->tin_file)
                    <a href="{{ asset($user->vendor->tin_file) }}"
                       target="_blank"
                       class="btn btn-info btn-block">
                        <i class="fas fa-file-alt"></i> View TIN File
                    </a>
                @else
                    <button class="btn btn-secondary btn-block" disabled>
                        <i class="fas fa-times-circle"></i> Not Uploaded
                    </button>
                @endif

            </div>
        </div>
    </div>

    <!-- BIN -->
    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">BIN File</h5>

                @if($user->vendor->bin_file)
                    <a href="{{ asset($user->vendor->bin_file) }}"
                       target="_blank"
                       class="btn btn-success btn-block">
                        <i class="fas fa-file-alt"></i> View BIN File
                    </a>
                @else
                    <button class="btn btn-secondary btn-block" disabled>
                        <i class="fas fa-times-circle"></i> Not Uploaded
                    </button>
                @endif

            </div>
        </div>
    </div>

    <!-- Cancelled Cheque -->
    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">Cancelled Cheque</h5>

                @if($user->vendor->cancelled_cheque)
                    <a href="{{ asset($user->vendor->cancelled_cheque) }}"
                       target="_blank"
                       class="btn btn-warning btn-block">
                        <i class="fas fa-file-alt"></i> View Cheque
                    </a>
                @else
                    <button class="btn btn-secondary btn-block" disabled>
                        <i class="fas fa-times-circle"></i> Not Uploaded
                    </button>
                @endif

            </div>
        </div>
    </div>

</div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection