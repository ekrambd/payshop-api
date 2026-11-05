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

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from portotheme.com/html/wolmart/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 04 Oct 2025 04:53:17 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>Defi eCommmerce</title>

    <meta name="keywords" content="Defi eCommmerce Website" />
    <meta name="description" content="Defi eCommmerce Website">
    <meta name="author" content="D-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('logo-icons/defi_icon.png')}}">

    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: { families: ['Poppins:400,500,600,700'] }
        };
        ( function ( d ) {
            var wf = d.createElement( 'script' ), s = d.scripts[0];
            wf.src = '{{asset('front/assets')}}/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore( wf, s );
        } )( document );
    </script>

    <link rel="preload" href="{{asset('front/assets')}}/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
    <link rel="preload" href="{{asset('front/assets')}}/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
    <link rel="preload" href="{{asset('front/assets')}}/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2"
            crossorigin="anonymous">
    <link rel="preload" href="{{asset('front/assets')}}/fonts/wolmart87d5.woff?png09e" as="font" type="font/woff" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets')}}/vendor/fontawesome-free/css/all.min.css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets')}}/vendor/magnific-popup/magnific-popup.min.css">

    <link rel="stylesheet" href="{{asset('front/assets')}}/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets')}}/vendor/photoswipe/photoswipe.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets')}}/vendor/photoswipe/default-skin/default-skin.min.css">
    <!-- Swiper's CSS -->
    <link rel="stylesheet" href="{{asset('front/assets')}}/vendor/swiper/swiper-bundle.min.css">

    <!-- Default CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets')}}/css/style.min.css">


</head>

<body>
    <div class="page-wrapper">
        <h1 class="d-none">Wolmart - Responsive Marketplace HTML Template</h1>
        <!-- Start of Header -->
        <header class="header header-border">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <p class="welcome-msg">Welcome to DefI Ecommerce message or remove it!</p>
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
                        <a href="contact-us.html" class="d-lg-show d-none">Contact Us</a>
                        @if(Auth::check())
                         <a href="{{url('/my-account')}}" class="d-lg-show d-none">My Account</a>
                         <a href="{{url('/user-logout')}}" class="d-lg-show">Logout ( {{Auth::user()->name}} )</a>
                        @else
                        <a href="{{url('/user-auth')}}" class="login-user auth-button"><i
                                class="w-icon-account"></i>Sign In</a>
                        <span class="delimiter d-lg-show">/</span>
                        <a href="{{url('/user-auth')}}" class="register-user auth-button ml-0">Register</a>
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
                        <form method="get" action="#" class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">
                            <div class="select-box">
                                <select id="category" name="category">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" class="form-control" name="search" id="search"
                                placeholder="Search in..." required />
                            <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header-right ml-4">
                        <div class="header-call d-xs-show d-lg-flex align-items-center">
                            <a href="tel:#" class="w-icon-call"></a>
                            <div class="call-info d-lg-show">
                                <h4 class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0">
                                    <a href="https://portotheme.com/cdn-cgi/l/email-protection#2e0d" class="text-capitalize">Live Chat</a> or :</h4>
                                <a href="tel:#" class="phone-number font-weight-bolder ls-50">+971 54 725 4393</a>
                            </div>
                        </div>
                        <a class="wishlist label-down link d-xs-show" href="{{url('/my-wishlists')}}">
                            <i class="w-icon-heart"></i>
                            <span class="wishlist-label d-lg-show">Wishlist</span>
                        </a> 
                        <a class="compare label-down link d-xs-show d-none" href="compare.html">
                            <i class="w-icon-compare"></i>
                            <span class="compare-label d-lg-show">Compare</span>
                        </a>
                        <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                            <div class="cart-overlay"></div>
                            <a href="{{url('/cart-details')}}" class="label-down link">
                                <i class="w-icon-cart">
                                    <span class="cart-count">{{$cartCount}}</span>
                                </i>
                                <span class="cart-label">Cart</span>
                            </a>
                            <div class="dropdown-box">
                                <div class="cart-header">
                                    <span>Shopping Cart</span>
                                    <a href="#" class="btn-close">Close<i class="w-icon-long-arrow-right"></i></a>
                                </div>

                                <div class="products">
                                    <div class="product product-cart">
                                        <div class="product-detail">
                                            <a href="product-default.html" class="product-name">Beige knitted
                                                elas<br>tic
                                                runner shoes</a>
                                            <div class="price-box">
                                                <span class="product-quantity">1</span>
                                                <span class="product-price">$25.68</span>
                                            </div>
                                        </div>
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="{{asset('front/assets')}}/images/cart/product-1.jpg" alt="product" height="84"
                                                    width="94" />
                                            </a>
                                        </figure>
                                        <button class="btn btn-link btn-close" aria-label="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="product product-cart">
                                        <div class="product-detail">
                                            <a href="product-default.html" class="product-name">Blue utility
                                                pina<br>fore
                                                denim dress</a>
                                            <div class="price-box">
                                                <span class="product-quantity">1</span>
                                                <span class="product-price">$32.99</span>
                                            </div>
                                        </div>
                                        <figure class="product-media">
                                            <a href="product-default.html">
                                                <img src="{{asset('front/assets')}}/images/cart/product-2.jpg" alt="product" width="84"
                                                    height="94" />
                                            </a>
                                        </figure>
                                        <button class="btn btn-link btn-close" aria-label="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="cart-total">
                                    <label>Subtotal:</label>
                                    <span class="price">$58.67</span>
                                </div>

                                <div class="cart-action">
                                    <a href="cart.html" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                    <a href="checkout.html" class="btn btn-primary  btn-rounded">Checkout</a>
                                </div>
                            </div>
                            <!-- End of Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header Middle -->

            <div class="header-bottom sticky-content fix-top sticky-header">
                <div class="container">
                    <div class="inner-wrap">
                        <div class="header-left">
                            <div class="dropdown category-dropdown has-border" data-visible="true">
                                <a href="#" class="category-toggle" role="button" data-toggle="dropdown"
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
                                        </li>
                                     @endforeach
                                     <div class="text-center" style="margin-top:10px;"><a href="{{url('/shop')}}">See All Categories</a></div>
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
        <!-- End of Header -->

        <!-- Start of Main -->
        @yield('cart_content')
        <!-- End of Main -->

        <!-- Start of Footer -->
        <footer class="footer">
            <div class="footer-newsletter bg-primary pt-6 pb-6 d-none">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-5 col-lg-6">
                            <div class="icon-box icon-box-side text-white">
                                <div class="icon-box-icon d-inline-flex">
                                    <i class="w-icon-envelop3"></i>
                                </div>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-white text-uppercase mb-0">Subscribe To  Our Newsletter</h4>
                                    <p class="text-white">Get all the latest information on Events, Sales and Offers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 col-md-9 mt-4 mt-lg-0 ">
                            <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-rounded">
                                <input type="email" class="form-control mr-2 bg-white" name="email" id="email"
                                    placeholder="Your E-mail Address" />
                            <button class="btn btn-dark btn-rounded" type="submit">Subscribe<i
                                    class="w-icon-long-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="widget widget-about">
                                <a href="{{url('/')}}" class="logo-footer">
                                    <img src="{{asset('logo-icons/final_logo.png')}}" alt="logo-footer" width="144"
                                        height="45" />
                                </a>
                                <div class="widget-body">
                                    <p class="widget-about-title">Got Question? Call us 24/7</p>
                                    <a href="tel:+971 54 725 4393" class="widget-about-call">+971 54 725 4393</a>
                                    <p class="widget-about-desc">Register now to get updates on pronot get up icons
                                        & coupons ster now toon.
                                    </p>

                                    <div class="social-icons social-icons-colored d-none">
                                        <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                        <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                        <a href="#" class="social-icon social-instagram w-icon-instagram"></a>
                                        <a href="#" class="social-icon social-youtube w-icon-youtube"></a>
                                        <a href="#" class="social-icon social-pinterest w-icon-pinterest"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h3 class="widget-title">Company</h3>
                                <ul class="widget-body">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>
                                <ul class="widget-body">
                                    <li><a href="#">Signup</a></li>
                                    <li><a href="#">Signin</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4>
                                <ul class="widget-body">
                                    <li><a href="#">Payment Methods</a></li>
                                    <li><a href="#">Money-back guarantee!</a></li>
                                    <li><a href="#">Product Returns</a></li>
                                    <li><a href="#">Support Center</a></li>
                                    <li><a href="#">Shipping</a></li>
                                    <li><a href="#">Term and Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <div class="footer-left">
                        <p class="copyright">Copyright © {{date('Y')}} DefiCall Ecommerce Store. All Rights Reserved.</p>
                    </div>
                    <div class="footer-right">
                        <span class="payment-label mr-lg-8">We're using safe payment for</span>
                        <figure class="payment">
                            <img src="{{asset('front/assets')}}/images/payment.png" alt="payment" width="159" height="25" />
                        </figure>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Start of Sticky Footer -->
    <!-- Start of Sticky Footer -->
    <div class="sticky-footer sticky-content fix-bottom">
        <a href="{{url('/')}}" class="sticky-link active">
            <i class="w-icon-home"></i>
            <p>Home</p>
        </a>
        <a href="{{url('/shop')}}" class="sticky-link">
            <i class="w-icon-category"></i>
            <p>Shop</p>
        </a>
        <a href="{{url('/user-auth')}}" class="sticky-link">
            <i class="w-icon-account"></i>
            <p>Signup/Signin</p>
        </a>
        <div class="cart-dropdown dir-up">
            <a href="{{url('/cart-details')}}" class="sticky-link">
                <i class="w-icon-cart"></i>
                <p>Cart</p>
            </a>
        </div>

        <div class="header-search hs-toggle dir-up">
            <a href="#" class="search-toggle sticky-link">
                <i class="w-icon-search"></i>
                <p>Search</p>
            </a>
            <form action="{{url('/search-product')}}" class="input-wrapper" method="GET">
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search"
                    required />
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- End of Sticky Footer -->
    <!-- End of Sticky Footer -->
    
    <!-- Start of Scroll Top -->
    <a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button"> <i class="w-icon-angle-up"></i> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70"> <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35" r="34" style="stroke-dasharray: 16.4198, 400;"></circle> </svg> </a>
    <!-- End of Scroll Top -->

    <!-- Start of Mobile Menu -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay"></div>
        <!-- End of .mobile-menu-overlay -->

        <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
        <!-- End of .mobile-menu-close -->

        <div class="mobile-menu-container scrollable">
            <form action="{{url('/search-product')}}" method="get" class="input-wrapper">
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search"
                    required />
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search"></i>
                </button>
            </form>
            <!-- End of Search Form -->
            <div class="tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#main-menu" class="nav-link active">Main Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="#categories" class="nav-link">Categories</a>
                    </li>
                    
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="main-menu">
                    <ul class="mobile-menu">
                        <li><a href="{url('/')}}">Home</a></li>
                        <li>
                            <a href="{{url('/shop')}}">Shop</a>
                        </li>
                        <!--<li>-->
                        <!--    <a href="{{url('/vendor-signup')}}">Signup as Vendor</a>-->
                        <!--</li>-->
                        <li>
                            <a href="{{url('/vendor-login')}}">Vendor Signin</a>
                        </li>
                        {{-- <li>
                            <a href="vendor-dokan-store.html">Vendor</a>
                            <ul>
                                <li>
                                    <a href="#">Store Listing</a>
                                    <ul>
                                        <li><a href="vendor-dokan-store-list.html">Store listing 1</a></li>
                                        <li><a href="vendor-wcfm-store-list.html">Store listing 2</a></li>
                                        <li><a href="vendor-wcmp-store-list.html">Store listing 3</a></li>
                                        <li><a href="vendor-wc-store-list.html">Store listing 4</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Vendor Store</a>
                                    <ul>
                                        <li><a href="vendor-dokan-store.html">Vendor Store 1</a></li>
                                        <li><a href="vendor-wcfm-store-product-grid.html">Vendor Store 2</a></li>
                                        <li><a href="vendor-wcmp-store-product-grid.html">Vendor Store 3</a></li>
                                        <li><a href="vendor-wc-store-product-grid.html">Vendor Store 4</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="blog.html">Blog</a>
                            <ul>
                                <li><a href="blog.html">Classic</a></li>
                                <li><a href="blog-listing.html">Listing</a></li>
                                <li>
                                    <a href="https:/www.portotheme.com/html/wolmart/blog-grid.html">Grid</a>
                                    <ul>
                                        <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                        <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                        <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                        <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Masonry</a>
                                    <ul>
                                        <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                        <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                        <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                        <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Mask</a>
                                    <ul>
                                        <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                        <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="post-single.html">Single Post</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="about-us.html">Pages</a>
                            <ul>

                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="become-a-vendor.html">Become A Vendor</a></li>
                                <li><a href="contact-us.html">Contact Us</a></li>
                                <li><a href="login.html">Login</a></li>
                                <li><a href="faq.html">FAQs</a></li>
                                <li><a href="error-404.html">Error 404</a></li>
                                <li><a href="coming-soon.html">Coming Soon</a></li>
                                <li><a href="wishlist.html">Wishlist</a></li>
                                <li><a href="cart.html">Cart</a></li>
                                <li><a href="checkout.html">Checkout</a></li>
                                <li><a href="my-account.html">My Account</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="elements.html">Elements</a>
                            <ul>
                                <li><a href="element-products.html">Products</a></li>
                                <li><a href="element-titles.html">Titles</a></li>
                                <li><a href="element-typography.html">Typography</a></li>
                                <li><a href="element-categories.html">Product Category</a></li>
                                <li><a href="element-buttons.html">Buttons</a></li>
                                <li><a href="element-accordions.html">Accordions</a></li>
                                <li><a href="element-alerts.html">Alert &amp; Notification</a></li>
                                <li><a href="element-tabs.html">Tabs</a></li>
                                <li><a href="element-testimonials.html">Testimonials</a></li>
                                <li><a href="element-blog-posts.html">Blog Posts</a></li>
                                <li><a href="element-instagrams.html">Instagrams</a></li>
                                <li><a href="element-cta.html">Call to Action</a></li>
                                <li><a href="element-vendors.html">Vendors</a></li>
                                <li><a href="element-icon-boxes.html">Icon Boxes</a></li>
                                <li><a href="element-icons.html">Icons</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </div>
                <div class="tab-pane" id="categories">
                    @php
                     $categories = \App\Models\Category::where('status','Active')->take(12)->latest()->get();
                    @endphp
                    <ul class="mobile-menu">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{url('/category-details/'.$category->slug)}}">
                                <img src="{{$category->category_image}}" style="max-width: 30px; height: 30px; color: white;" alt="{{$category->category_name}}"> {{$category->category_name}}
                            </a>
                        </li>
                    @endforeach 
                    <div class="text-center" style="margin-top:10px;"><a href="{{url('/shop')}}">See All Categories</a></div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Mobile Menu -->

    <!-- Plugin JS File -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="{{asset('front/assets')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('front/assets')}}/vendor/sticky/sticky.js"></script>
    <script src="{{asset('front/assets')}}/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    

    <script src="{{asset('front/assets')}}/vendor/swiper/swiper-bundle.min.js"></script>
     <script src="{{asset('front/assets')}}/vendor/photoswipe/photoswipe.js"></script>
    <script src="{{asset('front/assets')}}/vendor/photoswipe/photoswipe-ui-default.js"></script>

    <!-- Swiper JS -->
    <script src="{{asset('front/assets')}}/vendor/swiper/swiper-bundle.min.js"></script>
    

    <!-- Main JS File -->
    <script src="{{asset('front/assets')}}/js/main.min.js"></script>

    

    <script>
      $(document).ready(function(){
      	  $(document).on('click', '.cart-increment',function(e){
      	  	  e.preventDefault();
      	  	  let cartID = $(this).data('id');
      	  	  let cartPrice = parseFloat($('.cart_product_price_'+cartID).text());
      	  	  let cartQty = parseFloat($('.cart_qty_'+cartID).val());
      	  	  cartQty+=1;
      	  	  $('.cart_qty_'+cartID).val(cartQty);
      	  	  let cartUnitTotal = 
      	  	  $('.cart_unit_total_'+cartID).text(cartPrice*cartQty);
      	  });

      	  $(document).on('click', '.cart-decrement',function(e){
      	  	  e.preventDefault();
      	  	  let cartID = $(this).data('id');
      	  	  let cartPrice = parseFloat($('.cart_product_price_'+cartID).text());
      	  	  let cartQty = parseFloat($('.cart_qty_'+cartID).val());
      	  	  cartQty-=1;
      	  	  if(cartQty < 1){
      	  	  	 return;
      	  	  }
      	  	  $('.cart_qty_'+cartID).val(cartQty);
      	  	  let cartUnitTotal = 
      	  	  $('.cart_unit_total_'+cartID).text(cartPrice*cartQty);
      	  });

      	  $(document).on('click', '.remove-cart', function(e){
      	  	if(confirm('Do you want to delete this?'))
      	    {
      	    	let cartId = $(this).data('id');
      	    	$.ajax({
	                url: "{{ url('/delete-cart') }}/" + cartId,
	                type: "GET",
	                success: function (data) {
	                	$('#cart_'+cartId).remove();
	                    window.location.reload();
	                }
	            });
      	  	     
      	    }		
      	  	 
      	  });

          $(document).on('change','#orderByFilter',function(){
               let val = $(this).val();
               if(val == 'default'){
                   window.location.reload();
               }else{

                   let ref = "{{url('/')}}/shop?value="+val;
                   window.location.href=ref;
               }
          });

      });	
    </script>
</body>


<!-- Mirrored from portotheme.com/html/wolmart/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 04 Oct 2025 04:53:21 GMT -->
</html>