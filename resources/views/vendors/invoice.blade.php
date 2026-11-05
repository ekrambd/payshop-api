@extends('admin_master')

@section('content')

<style>

.invoice-box{
    background:#fff;
    padding:30px;
    border:1px solid #ddd;
    margin-bottom:20px;
}

.invoice-title{
    font-size:32px;
    font-weight:700;
    color:#333;
}

.company-name{
    font-size:24px;
    font-weight:bold;
}

.table td,
.table th{
    vertical-align:middle!important;
}

.summary-table td{
    padding:8px 15px;
}

@media print{

    .no-print{
        display:none!important;
    }

    .content-header{
        display:none;
    }

    .main-footer{
        display:none;
    }

    .card{
        border:none!important;
        box-shadow:none!important;
    }

    .content-wrapper{
        background:#fff!important;
    }

}

</style>

<div class="content-wrapper">

<section class="content pt-3">

<div class="container-fluid">

<div class="card">

<div class="card-body">

<div class="invoice-box">

<div class="row mb-4">

<div class="col-md-6">

    {{-- Company Logo --}}
    <img src="{{ asset('logo-icons/logo.png') }}"
         style="height:80px;">

    <h2 class="company-name mt-3">
        DefiCall Ecommerce
    </h2>

    <p class="mb-0">
        DSO IFZA, IFZA PROPERTIES
       Dubai Silicon Oasis
    </p>

    <p class="mb-0">
        UAE
    </p>

    <p class="mb-0">
        Phone :
        +971 54 725 4393
    </p>

    <p class="mb-0">
        Email :
        support@example.com
    </p>

</div>

<div class="col-md-6 text-right">

    <h1 class="invoice-title">
        INVOICE
    </h1>

    <table class="table table-bordered">

        <tr>

            <th width="40%">
                Invoice No
            </th>

            <td>
                {{ $order->invoice_no }}
            </td>

        </tr>

        <tr>

            <th>
                Order ID
            </th>

            <td>
                #{{ $order->id }}
            </td>

        </tr>

        <tr>

            <th>
                Date
            </th>

            <td>
                {{ $order->date }}
            </td>

        </tr>

        <tr>

            <th>
                Time
            </th>

            <td>
                {{ $order->time }}
            </td>

        </tr>

        <tr>

            <th>
                Status
            </th>

            <td>

                @if($order->status=="Completed")

                    <span class="badge badge-success">
                        {{ $order->status }}
                    </span>

                @elseif($order->status=="Cancelled")

                    <span class="badge badge-danger">
                        {{ $order->status }}
                    </span>

                @else

                    <span class="badge badge-warning">
                        {{ $order->status }}
                    </span>

                @endif

            </td>

        </tr>

    </table>

</div>

</div>


<div class="row">

<div class="col-md-6">

<h5 class="mb-3">
    Billing Information
</h5>

<table class="table table-bordered">

<tr>
<th width="35%">Customer</th>
<td>{{ $order->user->name ?? $order->user_name }}</td>
</tr>

<tr>
<th>Phone</th>
<td>{{ $order->user_phone }}</td>
</tr>

<tr>
<th>Email</th>
<td>{{ $order->user_email }}</td>
</tr>

<tr>
<th>Country</th>
<td>{{ $order->user_country }}</td>
</tr>

<tr>
<th>City</th>
<td>{{ $order->user_city }}</td>
</tr>

</table>

</div>

<div class="col-md-6">

<h5 class="mb-3">
Shipping Address
</h5>

<div class="border p-3" style="min-height:180px;">

{!! nl2br(e($order->user_address)) !!}

</div>

</div>

</div>

<hr class="mb-4">

<h4 class="mb-3">
    Ordered Products
</h4>

<div class="table-responsive">

    <table class="table table-bordered">

        <thead class="bg-dark text-white">

        <tr>

            <th width="60">#</th>

            <th width="80">Image</th>

            <th>Product Details</th>

            <th width="100" class="text-center">
                Unit
            </th>

            <th width="120" class="text-right">
                Price
            </th>

            <th width="90" class="text-center">
                Qty
            </th>

            <th width="120" class="text-right">
                Discount
            </th>

            <th width="140" class="text-right">
                Total
            </th>

        </tr>

        </thead>

        <tbody>

        @php

            $grandTotal = 0;

        @endphp

        @foreach($products as $key => $product)

            @php

                $price = $product->purchase_price;

                $qty = $product->qty;

                $discount = $product->purchase_discount;

                $unit = $product->unit->unit_name ?? '';

                // যদি discount প্রতি পিস হয়
                $subtotal = ($price * $qty) - ($discount * $qty);

                $grandTotal += $subtotal;

            @endphp

            <tr>

                <td class="text-center">
                    {{ $key + 1 }}
                </td>

                <td>

                    <img src="{{ asset($product->featured_image) }}"
                         class="img-thumbnail"
                         width="65">

                </td>

                <td>

                    <strong style="font-size:16px;">
                        {{ $product->product_name }}
                    </strong>

                    @if($product->variants->count())

                        <hr class="my-2">

                        @foreach($product->variants as $variant)

                            <div class="mb-1">

                                <strong>
                                    {{ $variant->variant_name }}
                                </strong>

                                :

                                @foreach($variant->productVariants as $value)

                                    <span class="badge badge-info">

                                        {{ $value->variant_value }}

                                    </span>

                                @endforeach

                            </div>

                        @endforeach

                    @endif

                </td>

                <td class="text-center">

                    {{ $unit }}

                </td>

                <td class="text-right">

                    {{ $order->current_symbol }}

                    {{ number_format($price,2) }}

                </td>

                <td class="text-center">

                    {{ $qty }}

                </td>

                <td class="text-right">

                    {{ $order->current_symbol }}

                    {{ number_format($discount,2) }}

                </td>

                <td class="text-right">

                    <strong>

                        {{ $order->current_symbol }}

                        {{ number_format($subtotal,2) }}

                    </strong>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<hr class="mt-4 mb-4">

<div class="row">

    <div class="col-md-6">

        <h5 class="mb-3">
            Payment Information
        </h5>

        <table class="table table-bordered">

            <tr>

                <th width="40%">
                    Payment Status
                </th>

                <td>

                    @if($order->payment_status == 'Paid')

                        <span class="badge badge-success">
                            Paid
                        </span>

                    @else

                        <span class="badge badge-danger">
                            {{ $order->payment_status ?? 'Unpaid' }}
                        </span>

                    @endif

                </td>

            </tr>

            <tr>

                <th>
                    Delivery Type
                </th>

                <td>

                    @if($order->place_type=='inside')

                        Inside City

                    @elseif($order->place_type=='outside')

                        Outside City

                    @else

                        -

                    @endif

                </td>

            </tr>

            <tr>

                <th>
                    Order Status
                </th>

                <td>

                    {{ $order->status }}

                </td>

            </tr>

        </table>

    </div>

    <div class="col-md-6">

        <table class="table table-bordered summary-table">

            <tr>

                <th>
                    Product Total
                </th>

                <td class="text-right">

                    {{ $order->current_symbol }}

                    {{ number_format($grandTotal,2) }}

                </td>

            </tr>

            <tr>

                <th>
                    Delivery Charge
                </th>

                <td class="text-right">

                    {{ $order->current_symbol }}

                    {{ number_format($order->delivery_charge,2) }}

                </td>

            </tr>

            <tr>

                <th>
                    Weight Charge
                </th>

                <td class="text-right">

                    {{ $order->current_symbol }}

                    {{ number_format($order->weight_price,2) }}

                </td>

            </tr>

            @php

                $finalTotal =
                    $grandTotal
                    + $order->delivery_charge
                    + $order->weight_price;

            @endphp

            <tr class="bg-light">

                <th style="font-size:18px;">
                    Grand Total
                </th>

                <th class="text-right text-primary"
                    style="font-size:22px;">

                    {{ $order->current_symbol }}

                    {{ number_format($finalTotal,2) }}

                </th>

            </tr>

        </table>

    </div>

</div>

<hr>

<div class="row mt-5">

    <div class="col-md-6 text-center">

        <br><br>

        __________________________

        <br>

        Customer Signature

    </div>

    <div class="col-md-6 text-center">

        <br><br>

        __________________________

        <br>

        Authorized Signature

    </div>

</div>

<hr>

<div class="text-center text-muted mt-4">

    <h5>
        Thank You For Your Purchase!
    </h5>

    <p class="mb-1">
        Please keep this invoice for future reference.
    </p>

    <small>

        Generated on :
        {{ now()->format('d M Y h:i A') }}

    </small>

</div>

</div>

</div>

</div>

</section>

</div>
@endsection