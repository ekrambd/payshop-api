<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['throttle:60,1'])->group(function () {

	// ========================================================
	// FRONT PART APIS (DO NOT MODIFY - ALREADY IMPLEMENTED IN APP)
	// ========================================================
	Route::get('/sliders', [ApiController::class, 'sliders']);
	Route::get('/home-categories', [ApiController::class, 'homeCategories']);
	Route::get('/latest-products', [ApiController::class, 'latestProducts']);
	Route::get('/best-seller', [ApiController::class, 'bestSeller']);
	Route::get('/admin-verify-products', [ApiController::class, 'adminVerifyProducts']);
	Route::get('/category-details/{id}', [ApiController::class, 'categoryDetails']);
	Route::get('/subcategory-details/{id}', [ApiController::class, 'subcategoryDetails']);
	Route::get('/product-details/{id}', [ApiController::class, 'productDetails']);
	Route::post('search-product', [ApiController::class, 'searchProduct']);
	Route::get('/shop', [ApiController::class, 'shop']);

	// ========================================================
	// USER AUTHENTICATION APIS (POST - UNIFIED SIGNIN / SIGNUP)
	// ========================================================
	Route::post('user-auth', [ApiController::class, 'userAuth']);
	Route::post('user/auth', [ApiController::class, 'userAuth']);

	Route::post('user-signup', [ApiController::class, 'userAuth']);
	Route::post('user/signup', [ApiController::class, 'userAuth']);

	Route::post('user-signin', [ApiController::class, 'userAuth']);
	Route::post('user/signin', [ApiController::class, 'userAuth']);

	Route::post('user-signout', [ApiController::class, 'userSignOut']);
	Route::post('user/signout', [ApiController::class, 'userSignOut']);

	// ========================================================
	// USER PANEL APIS (POST)
	// ========================================================
	// Dashboard Summary
	Route::post('user-dashboard', [ApiController::class, 'userDashboardSummary']);
	Route::post('user/dashboard-summary', [ApiController::class, 'userDashboardSummary']);

	// Profile Update
	Route::post('user-profile-update', [ApiController::class, 'userProfileUpdate']);
	Route::post('user/profile-update', [ApiController::class, 'userProfileUpdate']);

	// Password Change
	Route::post('user-change-password', [ApiController::class, 'userPasswordChange']);
	Route::post('user/password-change', [ApiController::class, 'userPasswordChange']);

	// User's Orders with Filters
	Route::post('user-orders', [ApiController::class, 'userOrders']);
	Route::post('user/orders', [ApiController::class, 'userOrders']);
	Route::post('order-details', [ApiController::class, 'userOrderDetails']);
	Route::post('user/order-details', [ApiController::class, 'userOrderDetails']);

	// ========================================================
	// WHITELIST / WISHLIST APIS (POST - USER MUST LOGIN)
	// ========================================================
	Route::post('whitelist-add', [ApiController::class, 'whitelistAdd']);
	Route::post('whitelist/add', [ApiController::class, 'whitelistAdd']);
	Route::post('wishlist/add', [ApiController::class, 'whitelistAdd']);

	Route::post('whitelist', [ApiController::class, 'whitelistList']);
	Route::post('whitelist/list', [ApiController::class, 'whitelistList']);
	Route::post('wishlist', [ApiController::class, 'whitelistList']);
	Route::post('wishlist/list', [ApiController::class, 'whitelistList']);

	Route::post('whitelist-remove', [ApiController::class, 'whitelistRemove']);
	Route::post('whitelist/remove', [ApiController::class, 'whitelistRemove']);
	Route::post('wishlist/remove', [ApiController::class, 'whitelistRemove']);

	// ========================================================
	// CART & ORDER APIS (POST - 2 APIS LINKED BY ID)
	// 1. Cart Stock & Items -> POST /api/cart-details
	// 2. Save Order        -> POST /api/save-order
	// ========================================================
	Route::post('currency-lists', [ApiController::class, 'currencyLists']);
	Route::get('currency-lists', [ApiController::class, 'currencyLists']);
	Route::post('cart-details', [ApiController::class, 'checkCartStock']);
	Route::post('check-cart-stock', [ApiController::class, 'checkCartStock']);
	Route::post('save-order', [ApiController::class, 'saveOrder']);

	// ========================================================
	// ORDER TRACKING API (POST)
	// ========================================================
	Route::post('order-tracking', [ApiController::class, 'orderTracking']);
	Route::post('track-order', [ApiController::class, 'orderTracking']);
	Route::post('order/track', [ApiController::class, 'orderTracking']);

	// ========================================================
	// RATING & REVIEW APIS (POST)
	// ========================================================
	Route::post('product/add-review', [ApiController::class, 'addReview']);
	Route::post('product-review', [ApiController::class, 'addReview']);
	Route::post('add-review', [ApiController::class, 'addReview']);

	Route::post('product/reviews', [ApiController::class, 'productReviews']);
	Route::post('product-reviews', [ApiController::class, 'productReviews']);

	// ========================================================
	// VENDOR APIS
	// ========================================================
	Route::post('vendor-signup', [ApiController::class, 'vendorSignup']);
	Route::post('vendor-signin', [ApiController::class, 'vendorSignin']);

	Route::get('/category-lists', [ApiController::class, 'categoryLists']);
	Route::get('/subcategory-lists', [ApiController::class, 'subcategoryLists']);
	Route::get('/variant-lists', [ApiController::class, 'variantLists']);

	Route::middleware(['auth:sanctum', 'role:2'])
	->prefix('vendor')
	->group(function () {
		Route::post('signout', [ApiController::class, 'vendorSignout']);
		Route::post('save-product', [ApiController::class, 'saveProduct']);
		Route::get('/product-lists', [ApiController::class, 'productLists']);
		Route::get('/product/details/{id}', [ApiController::class, 'vendorproductDetails']);
		Route::patch('/product-update/{id}', [ApiController::class, 'productUpdate']);
		Route::delete('/product-delete/{id}', [ApiController::class, 'productDelete']);
		Route::post('/product-status-update', [ApiController::class, 'productStatusUpdate']);
		Route::get('/product-variant-lists/{id}', [ApiController::class, 'productVariantLists']);
	});

	Route::middleware(['auth:sanctum', 'role:3'])->group(function () {
		// Authenticated user sanctum routes if needed
	});
});
