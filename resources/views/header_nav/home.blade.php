@php
 $categories = \App\Models\Category::where('status','Active')->latest()->take(10)->get();

$getCurrency = Session::get('currency');
if($getCurrency == 'usd_rate'){
	$currency = 'USD';
}elseif($getCurrency == 'jpn_rate'){
	$currency = 'JPY';
}elseif($getCurrency == 'ksa_riyal'){
	$currency = 'SAR';
}elseif($getCurrency == 'uae_rate'){
    $currency = 'AED';
}else{
	$currency = 'BDT';
} 

$cartCount = \App\Models\Cart::where('cart_session_id',Session::get('cart_session_id'))->count();

@endphp
<header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left" style="max-width: 30%;">
                        <p class="welcome-msg">Welcome to DeFiCall Ecommerce Store message or remove it!</p>
                    </div>
                    <div class="header-right">
                        <div class="dropdown currency-dropdown">
                            <a href="#currency" id="selected-currency">{{$currency}}</a>
                            <div class="dropdown-box">
                                <a href="#USD" class="current-value" data-id="usd_rate">USD</a>
                                <a href="#JPY" class="current-value" data-id="jpn_rate">JPY</a>
                                <a href="#SAR" class="current-value" data-id="ksa_riyal">SAR</a>
                                <a href="#BDT" class="current-value" data-id="bdt_rate">BDT</a> 
                                <a href="#AED" class="current-value" data-id="uae_rate">AED</a>
                            </div>
                        </div> 
                        <!-- End of DropDown Menu -->

                        <div class="dropdown d-none">
                            <a href="#language"><img src="{{asset('front/assets')}}/images/flags/eng.png" alt="ENG Flag" width="14"
                                    height="8" class="dropdown-image" /> ENG</a>
                            <div class="dropdown-box">
                                <a href="#ENG">
                                    <img src="{{asset('front/assets')}}/images/flags/eng.png" alt="ENG Flag" width="14" height="8"
                                        class="dropdown-image" />
                                    ENG
                                </a>
                                <a href="#FRA">
                                    <img src="{{asset('front/assets')}}/images/flags/fra.png" alt="FRA Flag" width="14" height="8"
                                        class="dropdown-image" />
                                    FRA
                                </a>
                            </div>
                        </div>
                        <!-- End of Dropdown Menu -->
                        <span class="divider d-lg-show"></span>
                        <a href="blog.html" class="d-lg-show d-none">Blog</a>
                        <a href="#" class="d-lg-show d-none">Contact Us</a>
                       
                        @if(Auth::check())
                         <a href="{{url('/my-account')}}" class="d-lg-show">My Account</a>
                         <a href="{{url('/user-logout')}}" class="d-lg-show">Logout ( {{Auth::user()->name}} )</a>
                        @else
                        <a href="{{url('/user-auth')}}" class="login-user auth-button"><i
                                class="w-icon-account"></i>Sign In</a>
                        <span class="delimiter d-lg-show">/</span>
                        <a href="{{url('/user-auth')}}" class="register-user auth-button ml-0"> Register</a>
                        @endif
                    </div>
                </div>
            </div> 
            <!-- End of Header Top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left mr-md-4">
                        <a href="#" class="mobile-menu-toggle  w-icon-hamburger" aria-label="menu-toggle">
                        </a>
                        <a href="{{url('/')}}" class="logo ml-lg-0">
                            <img src="{{asset('logo-icons/final_logo.png')}}" alt="logo" width="144" height="45" />
                        </a>
                        <form method="get" action="{{url('/search-product')}}"
                            class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">
                            <div class="select-box">
                                <select id="category" name="category_id">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <input type="text" class="form-control" name="search" id="search" placeholder="Search in..."
                                required />
                            <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header-right ml-4">

                        <a class="wishlist label-down link d-xs-show" href="{{url('/my-wishlists')}}">
                            <i class="w-icon-heart"></i>
                            <span class="wishlist-label d-lg-show">Wishlist</span>
                        </a>

                        <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                            <div class="cart-overlay"></div>
                            <a href="{{url('/cart-details')}}" class="label-down link">
                                <i class="w-icon-cart">
                                    <span class="cart-count">{{$cartCount}}</span>
                                </i>
                                <span class="cart-label">Cart</span>
                            </a>
                            
                            <!-- End of Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header Middle -->

            <div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
                <div class="container">
                    <div class="inner-wrap">
                        <div class="header-left">
                            <div class="dropdown category-dropdown has-border" data-visible="true">
                                <a href="#" class="category-toggle text-dark" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="true" data-display="static"
                                    title="Browse Categories">
                                    <i class="w-icon-category"></i>
                                    <span>Browse Categories</span>
                                </a>

                                <div class="dropdown-box">
                                    <ul class="menu vertical-menu category-menu">
                                     @foreach($categories as $category)
                                        <li>
                                            <a href="{{url('/category-details/'.$category->slug)}}">
                                                <img src="{{$category->category_image}}" style="max-width: 30px; height: 30px;" alt="{{$category->category_name}}"> {{$category->category_name}}
                                            </a>
                                            @if(count($category->subcategories) > 0) 
                                            <ul class="megamenu"> 
                                              <li>
                                                    <h4 class="menu-title">{{$category->category_name}}</h4>
                                                    <hr class="divider">
                                                    <ul>
                                                    @foreach($category->subcategories as $subcategory)
                                                        <li><a href="{{url('/subcategory-details/'.$subcategory->id)}}">{{$subcategory->subcategory_name}}</a>
                                                    @endforeach
                                                    </ul>
                                                </li>

                                            </ul> 
                                           @endif   
                                        </li>
                                     @endforeach
                                     <div class="text-center" style="margin-top:5px;"><a href="{{url('/shop')}}">See All Categories</a></div>
                                    </ul>
                                    
                                </div>
                            </div> 
                            <nav class="main-nav">
                                <ul class="menu active-underline">
                                    <li class="active">
                                        <a href="{{url('/')}}">Home</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/shop')}}">Shop</a>
                                    </li>

                                    <li>
                                        <a href="{{url('/checkout')}}">Checkout</a>
                                    </li>


                                    <li>
                                        <a href="{{url('/vendor-signup')}}">Register as Vendor</a>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                        <div class="header-right d-none">
                            <a href="#" class="d-xl-show"><i class="w-icon-map-marker mr-1"></i>Track Order</a>
                            <a href="#"><i class="w-icon-sale"></i>Daily Deals</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

