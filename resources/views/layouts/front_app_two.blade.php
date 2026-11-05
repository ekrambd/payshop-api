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

<main class="main cart">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="active"><a href="{{url('/cart-details')}}">Shopping Cart</a></li>
                        <li><a href="{{url('/checkout')}}">Checkout</a></li>
                        <li><a href="#">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg mb-10">
                        <div class="col-lg-8 pr-lg-4 mb-6">
                         <form action="{{ url('update-cart') }}" method="POST">
                         	@csrf
                            <table class="shop-table cart-table">
                                <thead>
                                    <tr>
                                        <th class="product-name"><span>Product</span></th>
                                        <th></th>
                                        <th class="product-price"><span>Price</span></th>
                                        <th class="product-quantity"><span>Quantity</span></th>
                                        <th class="product-subtotal"><span>Subtotal</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($products as $cart)
                                    <tr id="cart_{{$cart->id}}">
                                        <td class="product-thumbnail">
                                            <div class="p-relative">
                                                <a href="{{url('/product-details/'.$cart->slug)}}">
                                                    <figure>
                                                        <img src="{{$cart->product_image}}" alt="product"
                                                            width="300" height="338">
                                                    </figure>
                                                </a>
                                                <button type="button" class="btn btn-close remove-cart" data-id="{{$cart->id}}"><i
                                                        class="fas fa-times"></i></button>
                                            </div>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{url('/product-details/'.$cart->slug)}}">
                                                {{$cart->product_name}}
                                            </a>
                                            @if(count($cart->variants) > 0)
                                            <br/>
                                            @foreach($cart->variants as $variant)
                                            <span>
                                             {{$variant->variant_name}}: {{$variant->productVariants[0]->variant_value}}  
                                            </span><br/>
                                            @endforeach
                                            @endif
                                        </td>
                                        <td class="product-price"><span class="amount">{{$cart->current_symbol}} <span class="cart_product_price_{{$cart->id}}">{{$cart->cart_price}}</span></span></td>
                                        <td class="product-quantity">
                                            <div class="input-group">
                                            	<input type="hidden"
				                           name="cart_ids[]"
				                           value="{{$cart->id}}"> 
                                                <input class="form-control cart_qty_{{$cart->id}}" type="number" name="cart_qty[{{$cart->id}}]" min="1" max="100000" value="{{$cart->cart_qty}}">
                                                <button class="quantity-plus w-icon-plus cart-increment" data-id="{{$cart->id}}"></button>
                                                <button class="quantity-minus w-icon-minus cart-decrement" data-id="{{$cart->id}}"></button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount cart_amount_{{$cart->id}}">{{$cart->current_symbol}} <span class="cart_unit_total_{{$cart->id}}">{{$cart->unit_total}}</span></span>
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>

                            <div class="cart-action mb-6">
                                <a href="#" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                                <button type="submit" class="btn btn-rounded btn-default btn-clear" name="clear_cart" value="Clear Cart">Clear Cart</button> 
                                <button type="submit" class="btn btn-rounded btn-update" name="update_cart" value="Update Cart">Update Cart</button>
                            </div>
                         </form>

                            {{-- <form class="coupon">
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <input type="text" class="form-control mb-4" placeholder="Enter coupon code here..." required />
                                <button class="btn btn-dark btn-outline btn-rounded">Apply Coupon</button>
                            </form> --}}
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-4">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Subtotal</label>
                                        <span>{{$currency}} {{$sum}}</span>
                                    </div>

                                    <hr class="divider">

                                    <hr class="divider mb-6">
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Total</label>
                                        <span class="ls-50">{{$currency}} {{$sum}}</span>
                                    </div>
                                    <a href="{{url('/checkout')}}"
                                        class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>

                                    {{-- <a href="{{url('/checkout')}}"
                                        class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a> --}}
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
@endsection