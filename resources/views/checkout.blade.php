@php

 $getCurrency = Session::get('currency');
if($getCurrency == 'usd_rate'){
	$currency = '$';
}elseif($getCurrency == 'jpn_rate'){
	$currency = '¥';
}elseif($getCurrency == 'ksa_riyal'){
	$currency = 'SAR';
}else{
	$currency = '৳';
}


@endphp

@extends('cart_details')
@section('cart_content')
<!-- Start of Main -->
        <main class="main checkout">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="passed"><a href="cart.html">Shopping Cart</a></li>
                        <li class="active"><a href="checkout.html">Checkout</a></li>
                        <li><a href="order.html">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->


            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <form action="{{ url('/save-order') }}" method="POST" class="checkout-form">
			         @csrf
			         <input type="hidden" name="delivery_charge" value="{{$delivery_charge}}"/>
			    <div class="row mb-9">

			        <!-- Billing -->
			        <div class="col-lg-7 pr-lg-4 mb-4">

			            <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
			                Billing Details
			            </h3>

			            <div class="row gutter-sm">

			                <div class="col-12">
			                    <div class="form-group">
			                        <label for="user_name">Full Name <span class="text-danger">*</span></label>
			                        <input type="text"
			                               class="form-control form-control-md"
			                               id="user_name"
			                               name="user_name"
			                               placeholder="Full Name"
			                               value="{{auth()->check()?auth()->user()->name:''}}"
			                               required>
			                    </div>
			                </div>

			                <div class="col-12">
			                    <div class="form-group">
			                        <label for="user_email">Email</label>
			                        <input type="email"
			                               class="form-control form-control-md"
			                               id="user_email"
			                               name="user_email"
			                               value="{{auth()->check()?auth()->user()->email:''}}"
			                               placeholder="Email">
			                    </div>
			                </div>

			                <div class="col-12">
			                    <div class="form-group">
			                        <label for="user_phone">Phone <span class="text-danger">*</span></label>
			                        <input type="text"
			                               class="form-control form-control-md"
			                               id="user_phone"
			                               name="user_phone"
			                               placeholder="Phone"
			                               value="{{auth()->check()?auth()->user()->phone:''}}"
			                               required>
			                    </div>
			                </div>

			                <div class="col-12">
			                    <div class="form-group">
			                        <label for="user_country">Country <span class="text-danger">*</span></label>
			                        <input type="text"
			                               class="form-control form-control-md"
			                               id="user_country"
			                               name="user_country"
			                               value="Bangladesh"
			                               readonly
			                               required>
			                    </div>
			                </div>

			                <div class="col-12">
			                    <div class="form-group">
			                        <label for="user_city">City</label>
			                        <input type="text"
			                               class="form-control form-control-md"
			                               id="user_city"
			                               name="user_city"
			                               value="Dhaka"
			                               readonly>
			                    </div>
			                </div>

			                <div class="col-12">
			                    <div class="form-group">
			                        <label for="user_zipcode">Zip Code</label>
			                        <input type="text"
			                               class="form-control form-control-md"
			                               id="user_zipcode"
			                               name="user_zipcode"
			                               placeholder="Zip Code">
			                    </div>
			                </div>

			            </div>

			            <div class="form-group mt-3">
			                <label for="user_address">Address</label>
			                <textarea class="form-control"
			                          id="user_address"
			                          name="user_address"
			                          rows="4"
			                          placeholder="Enter your full address"></textarea>
			            </div>

			        </div>

			        <!-- Order Summary -->
			        <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">

			            <div class="order-summary-wrapper sticky-sidebar">

			                <h3 class="title text-uppercase ls-10">
			                    Your Order
			                </h3>

			                <div class="order-summary">

			                    <table class="order-table">

			                        <tbody>

			                            <tr class="cart-subtotal bb-no">
			                                <td>
			                                    <b>Subtotal</b>
			                                </td>
			                                <td>
			                                    <b>{{ $currency }}{{ $sum }}</b>
			                                </td>
			                            </tr>


			                            <tr class="cart-subtotal bb-no">
			                                <td>
			                                    <b>Delivery Charge</b>
			                                </td>
			                                <td>
			                                    <b>{{$currency}} {{$delivery_charge}}</b>
			                                </td>
			                            </tr>

			                        </tbody>

			                        <tfoot>

			                            <tr class="order-total">
			                                <th>
			                                    <b>Total</b>
			                                </th>
			                                <td>
			                                    <b>{{ $currency }}{{ $sum+$delivery_charge }}</b>
			                                </td>
			                                <p>Additional Charge Can be Added By Vendor With Your Order Total Price</p>
			                            </tr>

			                        </tfoot>

			                    </table>

			                    <!-- Payment Method -->
			                    <div class="payment-methods" id="payment_method">

			                        <h4 class="title font-weight-bold ls-25 pb-0 mb-1">
			                            Payment Method
			                        </h4>

			                        <div class="accordion payment-accordion">

			                            <div class="card">

			                                <div class="card-header">

			                                    <div class="custom-control custom-radio">

			                                        <input type="radio"
			                                               id="cash_on_delivery"
			                                               name="payment_method_id"
			                                               class="custom-control-input"
			                                               value="1"
			                                               checked
			                                               required>

			                                        <label class="custom-control-label"
			                                               for="cash_on_delivery">
			                                            Cash on Delivery
			                                        </label>

			                                    </div>

			                                </div>

			                                <div class="card-body">
			                                    <p class="mb-0">
			                                        Pay with cash upon delivery.
			                                    </p>
			                                </div>

			                            </div>

			                        </div>

			                    </div>

			                    <div class="form-group place-order pt-6">
			                        <button type="submit"
			                                class="btn btn-dark btn-block btn-rounded">
			                            Place Order
			                        </button>
			                    </div>

			                </div>

			            </div>

			        </div>

			    </div>

			</form>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->
@endsection