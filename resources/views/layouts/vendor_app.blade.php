@extends('admin_master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0">Vendor Dashboard</h1>
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

                <!-- Today's Orders -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>{{ $stats->today_orders }}</h3>

                            <p>Today's Orders</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>

                    </div>

                </div>

                <!-- Today's Completed Orders -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{ $stats->today_completed_orders }}</h3>

                            <p>Today's Completed</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>

                    </div>

                </div>

                <!-- This Month Orders -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-warning">

                        <div class="inner">

                            <h3>{{ $stats->this_month_orders }}</h3>

                            <p>This Month Orders</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>

                    </div>

                </div>

                <!-- This Year Orders -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>{{ $stats->this_year_orders }}</h3>

                            <p>This Year Orders</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>

                    </div>

                </div>

            </div>

            <div class="row">

                <!-- Total Products -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-primary">

                        <div class="inner">

                            <h3>{{ $productStats->total_products }}</h3>

                            <p>Total Products</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>

                    </div>

                </div>

                <!-- Active Products -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{ $productStats->active_products }}</h3>

                            <p>Active Products</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>

                    </div>

                </div>

                <!-- Pending Products -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-warning">

                        <div class="inner">

                            <h3>{{ $productStats->pending_products }}</h3>

                            <p>Inactive Products</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>

                    </div>

                </div>

                <!-- Verified Products -->

                <div class="col-lg-3 col-md-6">

                    <div class="small-box bg-teal">

                        <div class="inner">

                            <h3>{{ $productStats->verified_products }}</h3>

                            <p>Verified Products</p>

                        </div>

                        <div class="icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection