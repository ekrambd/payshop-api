@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <!-- Total Vendors -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>{{ $stats->total_vendors }}</h3>

                            <p>Total Vendors</p>

                        </div>

                        <div class="icon">

                            <i class="fas fa-store"></i>

                        </div>

                        <a href="{{ url('/vendors') }}" class="small-box-footer">

                            More Info
                            <i class="fas fa-arrow-circle-right"></i>

                        </a>

                    </div>

                </div>

                <!-- Total Customers -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{ $stats->total_users }}</h3>

                            <p>Total Customers</p>

                        </div>

                        <div class="icon">

                            <i class="fas fa-users"></i>

                        </div>

                        <a href="{{ url('/users') }}" class="small-box-footer">

                            More Info
                            <i class="fas fa-arrow-circle-right"></i>

                        </a>

                    </div>

                </div>

                <!-- Total Products -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-warning">

                        <div class="inner">

                            <h3>{{ $stats->total_products }}</h3>

                            <p>Total Products</p>

                        </div>

                        <div class="icon">

                            <i class="fas fa-box"></i>

                        </div>

                        <a href="{{ url('/products') }}" class="small-box-footer">

                            More Info
                            <i class="fas fa-arrow-circle-right"></i>

                        </a>

                    </div>

                </div>

                <!-- Active Products -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>{{ $stats->total_active_products }}</h3>

                            <p>Active Products</p>

                        </div>

                        <div class="icon">

                            <i class="fas fa-check-circle"></i>

                        </div>

                        <a href="{{ url('/products') }}" class="small-box-footer">

                            More Info
                            <i class="fas fa-arrow-circle-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection