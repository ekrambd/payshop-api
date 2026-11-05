@extends('master')
@section('front_content')
<div class="container">
                <div class="swiper-container appear-animate icon-box-wrapper br-sm mt-6 mb-6" data-swiper-options="{
                    'slidesPerView': 1,
                    'loop': false,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2
                        },
                        '768': {
                            'slidesPerView': 3
                        },
                        '1200': {
                            'slidesPerView': 4
                        }
                    }
                }" style="display:none;">
                    <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-1">
                        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                            <span class="icon-box-icon icon-shipping">
                                <i class="w-icon-truck"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Free Shipping & Returns</h4>
                                <p class="text-default">For all orders over $99</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                            <span class="icon-box-icon icon-payment">
                                <i class="w-icon-bag"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Secure Payment</h4>
                                <p class="text-default">We ensure secure payment</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side icon-box-primary icon-box-money">
                            <span class="icon-box-icon icon-money">
                                <i class="w-icon-money"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Money Back Guarantee</h4>
                                <p class="text-default">Any back within 30 days</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side icon-box-primary icon-box-chat">
                            <span class="icon-box-icon icon-chat">
                                <i class="w-icon-chat"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Customer Support</h4>
                                <p class="text-default">Call or email us 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Iocn Box Wrapper -->


            </div>

            <section class="category-section top-category bg-grey pt-10 pb-10 appear-animate">
                <div class="container pb-2">
                    <h2 class="title justify-content-center pt-1 ls-normal mb-5">Top Categories</h2>
                    <div class="swiper">
                        <div class="swiper-container swiper-theme pg-show" data-swiper-options="{
                            'spaceBetween': 20,
                            'slidesPerView': 2,
                            'breakpoints': {
                                '576': {
                                    'slidesPerView': 3
                                },
                                '768': {
                                    'slidesPerView': 5
                                },
                                '992': {
                                    'slidesPerView': 6
                                }
                            }
                        }">
                            <div class="swiper-wrapper row cols-lg-6 cols-md-5 cols-sm-3 cols-2">
                            @foreach($categories as $category)
                                <div
                                    class="swiper-slide category category-classic category-absolute overlay-zoom br-xs">
                                    <a href="{{url('/category-details/'.$category->slug)}}" class="category-media">
                                        <img src="{{$category->category_image}}" alt="Category" style="height: 150px!important;">
                                    </a>
                                    
                                    <p class="mt-2 text-center" style="color: #40158C">
                                        <a href="{{url('/category-details/'.$category->slug)}}">{{$category->category_name}}</a></p>
                                </div>
                            @endforeach
                            <div>See More</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End of .category-section top-category -->

            <div class="container">
                <h2 class="title justify-content-center ls-normal mb-4 mt-10 pt-1 appear-animate d-none">Popular Departments
                </h2>
                <div class="tab tab-nav-boxed tab-nav-outline appear-animate">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item mr-2 mb-2">
                            <a class="nav-link active br-sm font-size-md ls-normal" href="#tab1-1">New arrivals</a>
                        </li>
                        <li class="nav-item mr-2 mb-2">
                            <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-2">Best seller</a>
                        </li>
                        <li class="nav-item mr-2 mb-2">
                            <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-3">most popular</a>
                        </li>
                        <li class="nav-item mr-0 mb-2">
                            <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-4">Verified Products</a>
                        </li>
                    </ul>
                </div>
                <!-- End of Tab -->
                <div class="tab-content product-wrapper appear-animate">
                    <div class="tab-pane active pt-4" id="tab1-1">
                        <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                         @foreach($recentProducts as $row) 	
                            <div class="product-wrap" style="background: #d6b9fe;">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="{{url('/product-details/'.$row->slug)}}">
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                title="Add to cart" data-id="{{$row->id}}"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart add-to-wishlist"
                                                title="Add to wishlist" data-id="{{$row->id}}"></a>
                                        </div>
                                        @if($row->product_discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{$row->product_discount}}% Off</label>
                                        </div>
                                        @endif
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name" style="padding:0px 2px;"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>


                                        <div class="product-price">
                                        	@if($row->product_discount > 0)
                                        	<del class="old-price">{{$row->current_symbol}}{{$row->discount_price}}</del>
                                        	@endif
                                            <ins class="new-price">{{$row->current_symbol}}{{$row->original_price}}</ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach 
                        </div>
                    </div>
                    <!-- End of Tab Pane -->
                    <div class="tab-pane pt-4" id="tab1-2">
                        <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                        @foreach($bestSellProducts as $row) 	
                            <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="{{url('/product-details/'.$row->slug)}}">
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                title="Add to cart" data-id="{{$row->id}}"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart add-to-wishlist"
                                                title="Add to wishlist" data-id="{{$row->id}}"></a>
                                        </div>
                                        @if($row->product_discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{$row->product_discount}}% Off</label>
                                        </div>
                                        @endif
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>


                                        <div class="product-price">
                                        	@if($row->product_discount > 0)
                                        	<del class="old-price">{{$row->current_symbol}}{{$row->discount_price}}</del>
                                        	@endif
                                            <ins class="new-price">{{$row->current_symbol}}{{$row->original_price}}</ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                        </div>
                    </div>
                    <!-- End of Tab Pane -->
                    <div class="tab-pane pt-4" id="tab1-3">
                        <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                            @foreach($popularProducts as $row) 	
                            <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="{{url('/product-details/'.$row->slug)}}">
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                title="Add to cart" data-id="{{$row->id}}"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart add-to-wishlist"
                                                title="Add to wishlist" data-id="{{$row->id}}"></a>
                                        </div>
                                        @if($row->product_discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{$row->product_discount}}% Off</label>
                                        </div>
                                        @endif
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>


                                        <div class="product-price">
                                        	@if($row->product_discount > 0)
                                        	<del class="old-price">{{$row->current_symbol}}{{$row->discount_price}}</del>
                                        	@endif
                                            <ins class="new-price">{{$row->current_symbol}}{{$row->original_price}}</ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                        </div>
                    </div>
                    <!-- End of Tab Pane -->
                    <div class="tab-pane pt-4" id="tab1-4">
                        <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                            @foreach($verifyProducts as $row) 	
                            <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="{{url('/product-details/'.$row->slug)}}">
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                title="Add to cart" data-id="{{$row->id}}"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart add-to-wishlist"
                                                title="Add to wishlist" data-id="{{$row->id}}"></a>
                                        </div>
                                        @if($row->product_discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{$row->product_discount}}% Off</label>
                                        </div>
                                        @endif
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>


                                        <div class="product-price">
                                        	@if($row->product_discount > 0)
                                        	<del class="old-price">{{$row->current_symbol}}{{$row->discount_price}}</del>
                                        	@endif
                                            <ins class="new-price">{{$row->current_symbol}}{{$row->original_price}}</ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         @endforeach
                        </div>
                    </div>
                    <!-- End of Tab Pane -->
                </div>
                <!-- End of Tab Content -->



            <div class="product-wrapper-1 appear-animate mb-7 d-none">
                    <div class="title-link-wrapper pb-1 mb-4">
                        <h2 class="title ls-normal mb-0">Recent Products</h2>
                        <a href="{{url('/shop')}}" class="font-size-normal font-weight-bold ls-25 mb-0">More
                            Products<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                    <div class="row">

                        <!-- End of Banner -->
                        <div class="col-lg-12 col-sm-12">
                            <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '992': {
                                        'slidesPerView': 3
                                    },
                                    '1200': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">
                                <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
            
                                 @foreach($recentProducts as $row)
                                    <div class="swiper-slide product-col">
                                        <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="{{url('/product-details/'.$row->slug)}}">
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                title="Add to cart" data-id="{{$row->id}}"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart add-to-wishlist"
                                                title="Add to wishlist" data-id="{{$row->id}}"></a>
                                        </div>
                                        @if($row->product_discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{$row->product_discount}}% Off</label>
                                        </div>
                                        @endif
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>


                                        <div class="product-price">
                                            @if($row->product_discount > 0)
                                            <del class="old-price">{{$row->current_symbol}}{{$row->discount_price}}</del>
                                            @endif
                                            <ins class="new-price">{{$row->current_symbol}}{{$row->original_price}}</ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    </div>
                                 @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <!-- End of Produts -->
                        </div>
                    </div>
                </div>


            @foreach($homeCategories as $category)

                <div class="product-wrapper-1 appear-animate mb-7">
                    <div class="title-link-wrapper pb-1 mb-4">
                        <h2 class="title ls-normal mb-0">{{$category->category_name}}</h2>
                        <a href="{{url('/shop')}}" class="font-size-normal font-weight-bold ls-25 mb-0">More
                            Products<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                    <div class="row">

                        <!-- End of Banner -->
                        <div class="col-lg-12 col-sm-12">
                            <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '992': {
                                        'slidesPerView': 3
                                    },
                                    '1200': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">
                                <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
            
                                 @foreach($category->products as $row)
                                    <div class="swiper-slide product-col">
                                        <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="{{url('/product-details/'.$row->slug)}}">
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                            <img src="{{$row->product_image}}" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart"
                                                title="Add to cart" data-id="{{$row->id}}"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart add-to-wishlist"
                                                title="Add to wishlist" data-id="{{$row->id}}"></a>
                                        </div>
                                        @if($row->product_discount > 0)
                                        <div class="product-label-group">
                                            <label class="product-label label-discount">{{$row->product_discount}}% Off</label>
                                        </div>
                                        @endif
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>


                                        <div class="product-price">
                                        	@if($row->product_discount > 0)
                                        	<del class="old-price">{{$row->current_symbol}}{{$row->discount_price}}</del>
                                        	@endif
                                            <ins class="new-price">{{$row->current_symbol}}{{$row->original_price}}</ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    </div>
                                 @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <!-- End of Produts -->
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End of Product Wrapper 1 -->
                <!-- End of Reviewed Producs -->
            </div>
@endsection