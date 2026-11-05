<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from portotheme.com/html/wolmart/product-default.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 04 Oct 2025 04:52:55 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>{{$product->product_name}}</title> 

    <meta name="keywords" content="{{$product->product_name}}" />
    <meta name="description" content="{{$product->short_description}}" />
    <meta name="author" content="{{$product->user->name}}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{$product->product_image}}">

    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: { families: ['Poppins:400,500,600,700'] }
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '{{asset('front/assets')}}/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
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
    <link rel="stylesheet" type="text/css" href="{{asset('front/assets')}}/vendor/animate/animate.min.css">

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
        <!-- Start of Header -->
        <header class="header header-border">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <p class="welcome-msg">Welcome to Defi eCommerce Store</p>
                    </div>
                    <div class="header-right">
                        <div class="dropdown currency-dropdown">
                            <a href="#currency" id="selected-currency">{{$currency}}</a>
                            <div class="dropdown-box">
                                <a href="#USD" class="current-value" data-id="usd_rate">USD</a>
                                <a href="#JPY" class="current-value" data-id="jpn_rate">JPY</a>
                                <a href="#SAR" class="current-value" data-id="ksa_riyal">SAR</a>
                                <a href="#BDT" class="current-value" data-id="bdt_rate">BDT</a>
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
                                    <a href="https://portotheme.com/cdn-cgi/l/email-protection#381b" class="text-capitalize">Live Chat</a> or :</h4>
                                <a href="tel:#" class="phone-number font-weight-bolder ls-50">+971 54 725 4393</a>
                            </div>
                        </div>
                        <a class="wishlist label-down link d-xs-show" href="{{'/my-wishlists'}}">
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
                                    <a href="{{url('/cart-details')}}" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                    <a href="{{url('/')}}" class="btn btn-primary  btn-rounded">Checkout</a>
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
        <main class="main mb-10 pb-1">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav container">
                <ul class="breadcrumb bb-no">
                    <li><a href="demo1.html">Home</a></li>
                    <li>Products</li>
                </ul>
                <ul class="product-nav list-style-none">
                    <li class="product-nav-prev">
                        <a href="#">
                            <i class="w-icon-angle-left"></i>
                        </a>
                        <span class="product-nav-popup">
                            <img src="{{asset('front/assets')}}/images/products/product-nav-prev.jpg" alt="Product" width="110"
                                height="110" />
                            <span class="product-name">Soft Sound Maker</span>
                        </span>
                    </li>
                    <li class="product-nav-next">
                        <a href="#">
                            <i class="w-icon-angle-right"></i>
                        </a>
                        <span class="product-nav-popup">
                            <img src="{{asset('front/assets')}}/images/products/product-nav-next.jpg" alt="Product" width="110"
                                height="110" />
                            <span class="product-name">Fabulous Sound Speaker</span>
                        </span>
                    </li>
                </ul>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg">
                        <div class="main-content">
                            <div class="product product-single row">
                                <div class="col-md-6 mb-6">
                                    <div class="product-gallery product-gallery-sticky">
                                        <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                            <div class="swiper-wrapper row cols-1 gutter-no">
                                                <div class="swiper-slide" id="product-main-image">
                                                    <figure class="product-image">
                                                        <img src="{{$product->product_image}}"
                                                            data-zoom-image="{{$product->product_image}}"
                                                            alt="{{$product->product_name}}" width="800" height="900">
                                                    </figure>
                                                </div>
                                                @if(count($productImageVariants) > 0)
                                                @foreach($productImageVariants as $variant)
                                                <div class="swiper-slide">
                                                    <figure class="product-image">
                                                        <img src="{{URL::to($variant->image)}}"
                                                            data-zoom-image="{{URL::to($variant->image)}}"
                                                            alt="{{$variant->variant->variant_name}}" width="488" height="549">
                                                    </figure>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button>
                                            <a href="#" class="product-gallery-btn product-image-full"><i class="w-icon-zoom"></i></a>
                                        </div>
                                        <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                            'navigation': {
                                                'nextEl': '.swiper-button-next',
                                                'prevEl': '.swiper-button-prev'
                                            }
                                        }">
                                            <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                              <div class="product-thumb swiper-slide">
                                                    <img src="{{$product->product_image}}"
                                                        alt="{{$product->product_name}}" width="800" height="900">
                                                </div>
                                              @if(count($productImageVariants) > 0)
                                              @foreach($productImageVariants as $variant)
                                                <div class="product-thumb swiper-slide">
                                                    <img src="{{URL::to($variant->image)}}"
                                                        alt="{{$variant->variant->variant_name}}" width="800" height="900">
                                                </div>
                                              @endforeach
                                              @endif
                                            </div>
                                            <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 mb-md-6">
                                    <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                        <h1 class="product-title">{{$product->product_name}}</h1>
                                        <div class="product-bm-wrapper">
                                            <figure class="brand">
                                                <img src="{{URL::to($product->user->image)}}" alt="Brand"
                                                    width="102" height="48" />
                                            </figure>
                                            <div class="product-meta">
                                                <div class="product-categories">
                                                    Category:
                                                    <span class="product-category"><a href="#">{{$product->category->category_name}}</a></span>
                                                </div>
                                                <div class="product-sku">
                                                    Vendor Shop: <span>{{$product->user->vendor->shop_name}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="product-divider">
                                        @if($product->product_discount > 0)
                                        <div class="product-price"><ins class="new-price"><del>{{$product->current_symbol}}{{$product->original_price}}</del> {{$product->current_symbol}}{{$product->discount_price}}</ins></div>
                                        @else
                                        <div class="product-price"><ins class="new-price">{{$product->current_symbol}}{{$product->original_price}}</ins></div>
                                        @endif

                                        <div class="ratings-container d-none">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 80%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#product-tab-reviews" class="rating-reviews scroll-to">(3
                                                Reviews)</a>
                                        </div>

                                        <div class="product-short-desc">
                                           {{$product->short_description}}
                                        </div>

                                        <hr class="product-divider">
                                        @if(count($productVariants) > 0)
                                        @foreach($variants as $variant)
                                        @if($variant->variant_name == 'Color')
                                        <div class="product-form product-variation-form product-color-swatch">
                                            <label>Color:</label>
                                            <div class="d-flex align-items-center product-variations">
                                            @foreach($variant->productVariants as $row)
                                                <a href="#" class="color selected-variant-product" style="background-color: {{$row->variant_value}};" data-id="{{$row->id}}"></a>
                                            @endforeach
                                            </div>
                                        </div>
                                        @else
                                        <div class="product-form product-variation-form product-size-swatch">
                                            <label class="mb-1">{{$variant->variant_name}}:</label>
                                            <div class="flex-wrap d-flex align-items-center product-variations">
                                               @foreach($variant->productVariants as $row)
                                                <a href="#" class="size selected-variant-product" data-id="{{$row->id}}">{{$row->variant_value}}</a>
                                               @endforeach
                                            </div>
                                            <a href="{{url('/product-details/'.$product->slug)}}" class="product-variation-clean">Clean All</a>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif

                                        <form action="{{url('/save-single-cart')}}" method="POST">
                                         @csrf
                                         <input type="hidden" name="variant_ids" id="variant_ids"/>
                                         <input type="hidden" name="cart_product_id" id="cart_product_id" value="{{$product->id}}"/>
                                        <div class="fix-bottom product-sticky-content sticky-content">
                                            <div class="product-form container">
                                                <div class="product-qty-form">
                                                    <div class="input-group">
                                                        <input class="quantity form-control" name="cart_qty" type="number" min="1"
                                                            max="10000000">
                                                        <button class="quantity-plus w-icon-plus"></button>
                                                        <button class="quantity-minus w-icon-minus"></button>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="w-icon-cart"></i>
                                                    <span>Add to Cart</span>
                                                </button>
                                            </div>
                                        </div>
                                       </form>

                                        <div class="social-links-wrapper d-none">
                                            <div class="social-links">
                                                <div class="social-icons social-no-color border-thin">
                                                    <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                                    <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                                    <a href="#"
                                                        class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                    <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                    <a href="#"
                                                        class="social-icon social-youtube fab fa-linkedin-in"></a>
                                                </div>
                                            </div>
                                            <span class="divider d-xs-show"></span>
                                            <div class="product-link-wrapper d-flex">
                                                <a href="#"
                                                    class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                                <a href="#"
                                                    class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a href="#product-tab-description" class="nav-link active">Description</a>
                                    </li>
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="product-tab-description">
                                        <div class="row mb-4">
                                            <div class="col-md-12 mb-5">
                                                <h4 class="title tab-pane-title font-weight-bold mb-2">Detail</h4>
                                                <p>{!!$product->description!!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="product-tab-vendor">
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-4">
                                                <figure class="vendor-banner br-sm">
                                                    <img src="{{asset('front/assets')}}/images/products/vendor-banner.jpg"
                                                        alt="Vendor Banner" width="610" height="295"
                                                        style="background-color: #353B55;" />
                                                </figure>
                                            </div>
                                            <div class="col-md-6 pl-2 pl-md-6 mb-4">
                                                <div class="vendor-user">
                                                    <figure class="vendor-logo mr-4">
                                                        <a href="#">
                                                            <img src="{{asset('front/assets')}}/images/products/vendor-logo.jpg"
                                                                alt="Vendor Logo" width="80" height="80" />
                                                        </a>
                                                    </figure>
                                                    <div>
                                                        <div class="vendor-name"><a href="#">Jone Doe</a></div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 90%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="#" class="rating-reviews">(32 Reviews)</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="vendor-info list-style-none">
                                                    <li class="store-name">
                                                        <label>Store Name:</label>
                                                        <span class="detail">OAIO Store</span>
                                                    </li>
                                                    <li class="store-address">
                                                        <label>Address:</label>
                                                        <span class="detail">Steven Street, El Carjon, CA 92020, United
                                                            States (US)</span>
                                                    </li>
                                                    <li class="store-phone">
                                                        <label>Phone:</label>
                                                        <a href="#tel:">1234567890</a>
                                                    </li>
                                                </ul>
                                                <a href="vendor-dokan-store.html"
                                                    class="btn btn-dark btn-link btn-underline btn-icon-right">Visit
                                                    Store<i class="w-icon-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <p class="mb-5"><strong class="text-dark">L</strong>orem ipsum dolor sit amet,
                                            consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                            dolore magna aliqua.
                                            Venenatis tellus in metus vulputate eu scelerisque felis. Vel pretium
                                            lectus quam id leo in vitae turpis massa. Nunc id cursus metus aliquam.
                                            Libero id faucibus nisl tincidunt eget. Aliquam id diam maecenas ultricies
                                            mi eget mauris. Volutpat ac tincidunt vitae semper quis lectus. Vestibulum
                                            mattis ullamcorper velit sed. A arcu cursus vitae congue mauris.
                                        </p>
                                        <p class="mb-2"><strong class="text-dark">A</strong> arcu cursus vitae congue
                                            mauris. Sagittis id consectetur purus
                                            ut. Tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla.
                                            Diam in
                                            arcu cursus euismod quis. Eget sit amet tellus cras adipiscing enim eu. In
                                            fermentum et sollicitudin ac orci phasellus. A condimentum vitae sapien
                                            pellentesque
                                            habitant morbi tristique senectus et. In dictum non consectetur a erat. Nunc
                                            scelerisque viverra mauris in aliquam sem fringilla.</p>
                                    </div>
                                    <div class="tab-pane" id="product-tab-reviews">
                                        <div class="row mb-4">
                                            <div class="col-xl-4 col-lg-5 mb-4">
                                                <div class="ratings-wrapper">
                                                    <div class="avg-rating-container">
                                                        <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                                                        <div class="avg-rating">
                                                            <p class="text-dark mb-1">Average Rating</p>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 60%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                                <a href="#" class="rating-reviews">(3 Reviews)</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="ratings-value d-flex align-items-center text-dark ls-25">
                                                        <span
                                                            class="text-dark font-weight-bold">66.7%</span>Recommended<span
                                                            class="count">(2 of 3)</span>
                                                    </div>
                                                    <div class="ratings-list">
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 100%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <div class="progress-bar progress-bar-sm ">
                                                                <span></span>
                                                            </div>
                                                            <div class="progress-value">
                                                                <mark>70%</mark>
                                                            </div>
                                                        </div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 80%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <div class="progress-bar progress-bar-sm ">
                                                                <span></span>
                                                            </div>
                                                            <div class="progress-value">
                                                                <mark>30%</mark>
                                                            </div>
                                                        </div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 60%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <div class="progress-bar progress-bar-sm ">
                                                                <span></span>
                                                            </div>
                                                            <div class="progress-value">
                                                                <mark>40%</mark>
                                                            </div>
                                                        </div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 40%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <div class="progress-bar progress-bar-sm ">
                                                                <span></span>
                                                            </div>
                                                            <div class="progress-value">
                                                                <mark>0%</mark>
                                                            </div>
                                                        </div>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 20%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <div class="progress-bar progress-bar-sm ">
                                                                <span></span>
                                                            </div>
                                                            <div class="progress-value">
                                                                <mark>0%</mark>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-7 mb-4">
                                                <div class="review-form-wrapper">
                                                    <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your
                                                        Review</h3>
                                                    <p class="mb-3">Your email address will not be published. Required
                                                        fields are marked *</p>
                                                    <form action="#" method="POST" class="review-form">
                                                        <div class="rating-form">
                                                            <label for="rating">Your Rating Of This Product :</label>
                                                            <span class="rating-stars">
                                                                <a class="star-1" href="#">1</a>
                                                                <a class="star-2" href="#">2</a>
                                                                <a class="star-3" href="#">3</a>
                                                                <a class="star-4" href="#">4</a>
                                                                <a class="star-5" href="#">5</a>
                                                            </span>
                                                            <select name="rating" id="rating" required=""
                                                                style="display: none;">
                                                                <option value="">Rate…</option>
                                                                <option value="5">Perfect</option>
                                                                <option value="4">Good</option>
                                                                <option value="3">Average</option>
                                                                <option value="2">Not that bad</option>
                                                                <option value="1">Very poor</option>
                                                            </select>
                                                        </div>
                                                        <textarea cols="30" rows="6"
                                                            placeholder="Write Your Review Here..." class="form-control"
                                                            id="review"></textarea>
                                                        <div class="row gutter-md">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Your Name" id="author">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Your Email" id="email_1">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="checkbox" class="custom-checkbox"
                                                                id="save-checkbox">
                                                            <label for="save-checkbox">Save my name, email, and website
                                                                in this browser for the next time I comment.</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-dark">Submit
                                                            Review</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a href="#show-all" class="nav-link active">Show All</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#helpful-positive" class="nav-link">Most Helpful
                                                        Positive</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#helpful-negative" class="nav-link">Most Helpful
                                                        Negative</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#highest-rating" class="nav-link">Highest Rating</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#lowest-rating" class="nav-link">Lowest Rating</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="show-all">
                                                    <ul class="comments list-style-none">
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/1-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:54 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 60%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>pellentesque habitant morbi tristique senectus
                                                                        et. In dictum non consectetur a erat.
                                                                        Nunc ultrices eros in cursus turpis massa
                                                                        tincidunt ante in nibh mauris cursus mattis.
                                                                        Cras ornare arcu dui vivamus arcu felis bibendum
                                                                        ut tristique.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (0)
                                                                        </a>
                                                                        <div class="review-image">
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-1.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-1-800x900.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/2-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:52 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 80%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>Nullam a magna porttitor, dictum risus nec,
                                                                        faucibus sapien.
                                                                        Ultrices eros in cursus turpis massa tincidunt
                                                                        ante in nibh mauris cursus mattis.
                                                                        Cras ornare arcu dui vivamus arcu felis bibendum
                                                                        ut tristique.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (0)
                                                                        </a>
                                                                        <div class="review-image">
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-2.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-2.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-3.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-3.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/3-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:21 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 60%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>In fermentum et sollicitudin ac orci phasellus. A
                                                                        condimentum vitae
                                                                        sapien pellentesque habitant morbi tristique
                                                                        senectus et. In dictum
                                                                        non consectetur a erat. Nunc scelerisque viverra
                                                                        mauris in aliquam sem fringilla.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (0)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (1)
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane" id="helpful-positive">
                                                    <ul class="comments list-style-none">
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/1-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:54 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 60%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>pellentesque habitant morbi tristique senectus
                                                                        et. In dictum non consectetur a erat.
                                                                        Nunc ultrices eros in cursus turpis massa
                                                                        tincidunt ante in nibh mauris cursus mattis.
                                                                        Cras ornare arcu dui vivamus arcu felis bibendum
                                                                        ut tristique.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (0)
                                                                        </a>
                                                                        <div class="review-image">
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-1.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-1.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/2-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:52 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 80%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>Nullam a magna porttitor, dictum risus nec,
                                                                        faucibus sapien.
                                                                        Ultrices eros in cursus turpis massa tincidunt
                                                                        ante in nibh mauris cursus mattis.
                                                                        Cras ornare arcu dui vivamus arcu felis bibendum
                                                                        ut tristique.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (0)
                                                                        </a>
                                                                        <div class="review-image">
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-2.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-2-800x900.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-3.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-3-800x900.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane" id="helpful-negative">
                                                    <ul class="comments list-style-none">
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/3-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:21 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 60%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>In fermentum et sollicitudin ac orci phasellus. A
                                                                        condimentum vitae
                                                                        sapien pellentesque habitant morbi tristique
                                                                        senectus et. In dictum
                                                                        non consectetur a erat. Nunc scelerisque viverra
                                                                        mauris in aliquam sem fringilla.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (0)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (1)
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane" id="highest-rating">
                                                    <ul class="comments list-style-none">
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/2-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:52 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 80%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>Nullam a magna porttitor, dictum risus nec,
                                                                        faucibus sapien.
                                                                        Ultrices eros in cursus turpis massa tincidunt
                                                                        ante in nibh mauris cursus mattis.
                                                                        Cras ornare arcu dui vivamus arcu felis bibendum
                                                                        ut tristique.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (0)
                                                                        </a>
                                                                        <div class="review-image">
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-2.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-2-800x900.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-3.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-3-800x900.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane" id="lowest-rating">
                                                    <ul class="comments list-style-none">
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="{{asset('front/assets')}}/images/agents/1-100x100.png"
                                                                        alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <h4 class="comment-author">
                                                                        <a href="#">John Doe</a>
                                                                        <span class="comment-date">March 22, 2021 at
                                                                            1:54 pm</span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                            <span class="ratings"
                                                                                style="width: 60%;"></span>
                                                                            <span
                                                                                class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p>pellentesque habitant morbi tristique senectus
                                                                        et. In dictum non consectetur a erat.
                                                                        Nunc ultrices eros in cursus turpis massa
                                                                        tincidunt ante in nibh mauris cursus mattis.
                                                                        Cras ornare arcu dui vivamus arcu felis bibendum
                                                                        ut tristique.</p>
                                                                    <div class="comment-action">
                                                                        <a href="#"
                                                                            class="btn btn-secondary btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-up"></i>Helpful (1)
                                                                        </a>
                                                                        <a href="#"
                                                                            class="btn btn-dark btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize">
                                                                            <i class="far fa-thumbs-down"></i>Unhelpful
                                                                            (0)
                                                                        </a>
                                                                        <div class="review-image">
                                                                            <a href="#">
                                                                                <figure>
                                                                                    <img src="{{asset('front/assets')}}/images/products/default/review-img-3.jpg"
                                                                                        width="60" height="60"
                                                                                        alt="Attachment image of John Doe's review on Electronics Black Wrist Watch"
                                                                                        data-zoom-image="{{asset('front/assets')}}/images/products/default/review-img-3-800x900.jpg" />
                                                                                </figure>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <section class="related-product-section">
                                <div class="title-link-wrapper mb-4">
                                    <h4 class="title">Related Products</h4>
                                    <a href="#" class="btn btn-dark btn-link btn-slide-right btn-icon-right">More
                                        Products<i class="w-icon-long-arrow-right"></i></a>
                                </div>
                                <div class="swiper-container swiper-theme" data-swiper-options="{
                                    'spaceBetween': 20,
                                    'slidesPerView': 2,
                                    'breakpoints': {
                                        '576': {
                                            'slidesPerView': 3
                                        },
                                        '768': {
                                            'slidesPerView': 4
                                        },
                                        '992': {
                                            'slidesPerView': 3
                                        }
                                    }
                                }">
                                    <div class="swiper-wrapper row cols-lg-3 cols-md-4 cols-sm-3 cols-2">
                                    @foreach($relatedProducts as $row)
                                        <div class="swiper-slide product">
                                            <figure class="product-media">
                                                <a href="{{url('/product-details/'.$row->slug)}}">
                                                    <img src="{{$row->product_image}}" alt="Product"
                                                        width="300" height="338" />
                                                </a>
                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-cart w-icon-cart add-to-cart" 
                                                        title="Add to cart" data-id="{{$row->id}}"></a>
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist"></a>
                                                </div>
                                                <div class="product-action">
                                                    <a href="{{url('/product-details/'.$row->slug)}}" class="btn-product btn-quickview" title="Quick View">Quick
                                                        View</a>
                                                </div>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="{{url('/product-details/'.$row->slug)}}">{{$row->product_name}}</a></h4>
                                                <div class="ratings-container d-none">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                                                </div>
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price">$632.00</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>
                        <!-- End of Main Content -->
                        <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                            <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                            <div class="sidebar-content scrollable">
                                <div class="sticky-sidebar">
                                    <div class="widget widget-icon-box mb-6">
                                        <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-truck"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <h4 class="icon-box-title">Free Shipping & Returns</h4>
                                                <p>For all orders over $99</p>
                                            </div>
                                        </div>
                                        <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-bag"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <h4 class="icon-box-title">Secure Payment</h4>
                                                <p>We ensure secure payment</p>
                                            </div>
                                        </div>
                                        <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-money"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <h4 class="icon-box-title">Money Back Guarantee</h4>
                                                <p>Any back within 30 days</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Widget Icon Box -->

                                    <div class="widget widget-banner mb-9">
                                        <div class="banner banner-fixed br-sm">
                                            <figure>
                                                <img src="{{asset('front/assets')}}/images/shop/banner3.jpg" alt="Banner" width="266"
                                                    height="220" style="background-color: #1D2D44;" />
                                            </figure>
                                            <div class="banner-content">
                                                <div class="banner-price-info font-weight-bolder text-white lh-1 ls-25">
                                                    40<sup class="font-weight-bold">%</sup><sub
                                                        class="font-weight-bold text-uppercase ls-25">Off</sub>
                                                </div>
                                                <h4
                                                    class="banner-subtitle text-white font-weight-bolder text-uppercase mb-0">
                                                    Ultimate Sale</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Widget Banner -->

                                    <div class="widget widget-products">
                                        <div class="title-link-wrapper mb-2">
                                            <h4 class="title title-link font-weight-bold">More Products</h4>
                                        </div>

                                        <div class="swiper nav-top">
                                            <div class="swiper-container swiper-theme nav-top" data-swiper-options = "{
                                                'slidesPerView': 1,
                                                'spaceBetween': 20,
                                                'navigation': {
                                                    'prevEl': '.swiper-button-prev',
                                                    'nextEl': '.swiper-button-next'
                                                }
                                            }">
                                                <div class="swiper-wrapper">
                                                   @foreach($relatedProducts as $row)
                                                    <div class="widget-col swiper-slide">
                                                        <div class="product product-widget">
                                                            <figure class="product-media">
                                                                <a href="#">
                                                                    <img src="{{$row->product_image}}" alt="{{$row->product_name}}"
                                                                        width="100" height="113" />
                                                                </a>
                                                            </figure>
                                                            <div class="product-details">
                                                                <h4 class="product-name">
                                                                    <a href="#">{{$row->product_name}}</a>
                                                                </h4>
                                                                <div class="ratings-container d-none">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: 100%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="product-price">{{$row->current_symbol}}{{$row->original_price}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   @endforeach
                                                </div>
                                                <button class="swiper-button-next"></button>
                                                <button class="swiper-button-prev"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <!-- End of Sidebar -->
                    </div>
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->

        <!-- Start of Footer -->
        <footer class="footer appear-animate" data-animation-options="{
            'name': 'fadeIn'
        }">
            <div class="footer-newsletter bg-primary pt-6 pb-6">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-5 col-lg-6">
                            <div class="icon-box icon-box-side text-white">
                                <div class="icon-box-icon d-inline-flex">
                                    <i class="w-icon-envelop3"></i>
                                </div>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-white text-uppercase mb-0">Subscribe To Our
                                        Newsletter</h4>
                                    <p class="text-white">Get all the latest information on Events, Sales and Offers.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 col-md-9 mt-4 mt-lg-0 ">
                            <form action="#" method="get"
                                class="input-wrapper input-wrapper-inline input-wrapper-rounded">
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
                                <a href="demo1.html" class="logo-footer">
<<<<<<< HEAD
                                    <img src="{{asset('logo-icons/final_logo.png')}}" width="144"
=======
                                    <img src="{{asset('logo-icons/logo.png')}}" width="144"
>>>>>>> e7fee7fe58c8849376df04661a43d962a2a90538
                                        height="45" />
                                </a>
                                <div class="widget-body">
                                    <p class="widget-about-title">Got Question? Call us 24/7</p>
                                    <a href="tel:+971 54 725 4393" class="widget-about-call">+971 54 725 4393</a>
                                    <p class="widget-about-desc">Register now to get updates on pronot get up icons
                                        & coupons ster now toon.
                                    </p>

                                    <div class="social-icons social-icons-colored">
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
                        <p class="copyright">Copyright © {{date('Y')}} Defi Ecommerce. All Rights Reserved.</p>
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

    <!-- Root element of PhotoSwipe. Must have class pswp -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <!-- Background of PhotoSwipe. It's a separate element as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides.
			PhotoSwipe keeps only 3 of them in the DOM to save memory.
			Don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" aria-label="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--zoom" aria-label="Zoom in/out"></button>

                    <div class="pswp__preloader">
                        <div class="loading-spin"></div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button--arrow--left" aria-label="Previous (arrow left)"></button>
                <button class="pswp__button--arrow--right" aria-label="Next (arrow right)"></button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of PhotoSwipe -->

    <!-- Start of Quick View -->
    <div class="product product-single product-popup">
        <div class="row gutter-lg">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-gallery product-gallery-sticky">
                    <div class="swiper-container product-single-swiper swiper-theme nav-inner">
                        <div class="swiper-wrapper row cols-1 gutter-no">
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('front/assets')}}/images/products/popup/1-440x494.jpg"
                                        data-zoom-image="{{asset('front/assets')}}/images/products/popup/1-800x900.jpg"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('front/assets')}}/images/products/popup/2-440x494.jpg"
                                        data-zoom-image="{{asset('front/assets')}}/images/products/popup/2-800x900.jpg"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('front/assets')}}/images/products/popup/3-440x494.jpg"
                                        data-zoom-image="{{asset('front/assets')}}/images/products/popup/3-800x900.jpg"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                            <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="{{asset('front/assets')}}/images/products/popup/4-440x494.jpg"
                                        data-zoom-image="{{asset('front/assets')}}/images/products/popup/4-800x900.jpg"
                                        alt="Water Boil Black Utensil" width="800" height="900">
                                </figure>
                            </div>
                        </div>
                        <button class="swiper-button-next"></button>
                        <button class="swiper-button-prev"></button>
                    </div>
                    <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                        'navigation': {
                            'nextEl': '.swiper-button-next',
                            'prevEl': '.swiper-button-prev'
                        }
                    }">
                        <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('front/assets')}}/images/products/popup/1-103x116.jpg" alt="Product Thumb" width="103"
                                    height="116">
                            </div>
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('front/assets')}}/images/products/popup/2-103x116.jpg" alt="Product Thumb" width="103"
                                    height="116">
                            </div>
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('front/assets')}}/images/products/popup/3-103x116.jpg" alt="Product Thumb" width="103"
                                    height="116">
                            </div>
                            <div class="product-thumb swiper-slide">
                                <img src="{{asset('front/assets')}}/images/products/popup/4-103x116.jpg" alt="Product Thumb" width="103"
                                    height="116">
                            </div>
                        </div>
                        <button class="swiper-button-next"></button>
                        <button class="swiper-button-prev"></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 overflow-hidden p-relative">
                <div class="product-details scrollable pl-0">
                    <h2 class="product-title">Electronics Black Wrist Watch</h2>
                    <div class="product-bm-wrapper">
                        <figure class="brand">
                            <img src="{{asset('front/assets')}}/images/products/brand/brand-1.jpg" alt="Brand" width="102" height="48" />
                        </figure>
                        <div class="product-meta">
                            <div class="product-categories">
                                Category:
                                <span class="product-category"><a href="#">Electronics</a></span>
                            </div>
                            <div class="product-sku">
                                SKU: <span>MS46891340</span>
                            </div>
                        </div>
                    </div>

                    <hr class="product-divider">

                    <div class="product-price">$40.00</div>

                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width: 80%;"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="#" class="rating-reviews">(3 Reviews)</a>
                    </div>

                    <div class="product-short-desc">
                        <ul class="list-type-check list-style-none">
                            <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                            <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                            <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                        </ul>
                    </div>

                    <hr class="product-divider">

                    <div class="product-form product-variation-form product-color-swatch">
                        <label>Color:</label>
                        <div class="d-flex align-items-center product-variations">
                            <a href="#" class="color" style="background-color: #ffcc01"></a>
                            <a href="#" class="color" style="background-color: #ca6d00;"></a>
                            <a href="#" class="color" style="background-color: #1c93cb;"></a>
                            <a href="#" class="color" style="background-color: #ccc;"></a>
                            <a href="#" class="color" style="background-color: #333;"></a>
                        </div>
                    </div>
                    <div class="product-form product-variation-form product-size-swatch">
                        <label class="mb-1">Size:</label>
                        <div class="flex-wrap d-flex align-items-center product-variations">
                            <a href="#" class="size">Small</a>
                            <a href="#" class="size">Medium</a>
                            <a href="#" class="size">Large</a>
                            <a href="#" class="size">Extra Large</a>
                        </div>
                        <a href="#" class="product-variation-clean">Clean All</a>
                    </div>

                    <div class="product-variation-price">
                        <span></span>
                    </div>

                    <div class="product-form">
                        <div class="product-qty-form">
                            <div class="input-group">
                                <input class="quantity form-control" type="number" min="1" max="10000000">
                                <button class="quantity-plus w-icon-plus"></button>
                                <button class="quantity-minus w-icon-minus"></button>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-cart">
                            <i class="w-icon-cart"></i>
                            <span>Add to Cart</span>
                        </button>
                    </div>

                    <div class="social-links-wrapper">
                        <div class="social-links">
                            <div class="social-icons social-no-color border-thin">
                                <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                <a href="#" class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>
                            </div>
                        </div>
                        <span class="divider d-xs-show"></span>
                        <div class="product-link-wrapper d-flex">
                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                            <a href="#"
                                class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Quick view -->

    <!-- Plugin JS File -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="{{asset('front/assets')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('front/assets')}}/vendor/sticky/sticky.js"></script>
    <script src="{{asset('front/assets')}}/vendor/jquery.plugin/jquery.plugin.min.js"></script>
    <script src="{{asset('front/assets')}}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{asset('front/assets')}}/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="{{asset('front/assets')}}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{asset('front/assets')}}/vendor/zoom/jquery.zoom.js"></script>
    <script src="{{asset('front/assets')}}/vendor/photoswipe/photoswipe.js"></script>
    <script src="{{asset('front/assets')}}/vendor/photoswipe/photoswipe-ui-default.js"></script>

    <!-- Swiper JS -->
    <script src="{{asset('front/assets')}}/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="{{asset('front/assets')}}/js/main.min.js"></script>
    <script>
	$(document).ready(function () {

	    $(document).on('click', '.selected-variant-product', function (e) {
	        e.preventDefault();

	        let dataID = $(this).data('id');

	        $.ajax({
	            url: "{{ url('/variant-details') }}/" + dataID,
	            type: "GET",
	            dataType: "json",
	            success: function (response) {

	            	let baseURL = "{{ url('/') }}";
		            let imgPath="";
		            let alt="";
	            	if(response.data.image != null)
	                {

	                	imgPath = baseURL + "/" + response.data.image;
		                alt = @json($product->product_name);

		                $('#product-main-image').html(`
		                    <figure class="product-image">
		                        <img
		                            src="${imgPath}"
		                            data-zoom-image="${imgPath}"
		                            alt="${alt}"
		                            width="800"
		                            height="900">
		                    </figure>
		                `);
	                }else{
	                	imgPath = "{{$product->product_image}}";
		                alt = @json($product->product_name);

		                $('#product-main-image').html(`
		                    <figure class="product-image">
		                        <img
		                            src="${imgPath}"
		                            data-zoom-image="${imgPath}"
		                            alt="${alt}"
		                            width="800"
		                            height="900">
		                    </figure>
		                `);
	                }		

	                

	            }
	        });

	    });

        let variantIds = [];

	   $(document).on('click','.selected-variant-product',function(e){
          e.preventDefault();
          let varID = $(this).data('id');
          variantIds.push(varID);
          $('#variant_ids').val(variantIds);
       });



	});
	</script>
</body>


<!-- Mirrored from portotheme.com/html/wolmart/product-default.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 04 Oct 2025 04:53:17 GMT -->
</html>