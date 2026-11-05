<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\VendorProfileController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\VendorOrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
Route::get('/', [IndexController::class, 'indexPage'])->name('home');

Route::get('/vendor-signup', [VendorController::class, 'vendorSignup']);

Route::get('/vendor-login', [VendorController::class, 'vendorLogin']);

Route::post('vendor-signin', [VendorController::class, 'vendorSignin']); 

Route::get('/vendor/logout', [VendorController::class, 'vendorLogout']);

Route::post('save-vendor', [VendorController::class, 'saveVendor']);

Route::get('/set-currency/{currency}', [IndexController::class, 'setCurrency']);

Route::get('/admin/login', [IndexController::class, 'loginPage']);

Route::post('admin-login', [AccessController::class, 'adminLogin']);

Route::get('/admin/logout', [AccessController::class, 'adminLogout']);


Route::group(['middleware' => 'prevent-back-history'],function(){
  
  //admin dashboard

    Route::get('/dashboard', [DashboardController::class, 'adminDashboard']);

  //sliders

    Route::resource('sliders', SliderController::class);

  //categories

    Route::resource('categories', CategoryController::class);

  //subcategories

    Route::resource('subcategories', SubcategoryController::class);


  //units

    Route::resource('units', UnitController::class);

  //variants

    Route::resource('variants', VariantController::class);  

    /* ================= PRODUCT VARIANT ================= */

    Route::get('/add-product-variant/{id}', [VariantController::class, 'addProductVariant']);
    
    Route::post('/product-variant/save', [VariantController::class, 'saveProductVariant'])
        ->name('variants.product.save');

    Route::delete('/product-variant/{variant}', [VariantController::class, 'deleteProductVariant'])
        ->name('variants.product.delete');

  //products

   Route::resource('products', ProductController::class);
   Route::post('/product-status-update', [ProductController::class, 'statusUpdate']);
   Route::get('/add-delivery-charge/{id}', [ProductController::class, 'addDeliveryCharge']);
   Route::post('save-product-delivery-charge/{id}', [ProductController::class, 'saveProductDeliveryCharge']);

   //admin settings

   Route::get('/currency-settings', [SettingController::class, 'currencySettings']);

   Route::post('currency-settings-update', [SettingController::class, 'currencySettingsUpdate']);

   Route::get('/commission-settings', [SettingController::class, 'commissionSettings']);

   Route::post('save-commission-fee', [SettingController::class, 'saveCommissionFee']);

   Route::get('/vendor-lists', [CheckController::class, 'vendorLists']);

   Route::get('/vendor-details/{id}', [CheckController::class, 'vendorDetails']);
   
   Route::get('/vendor-products', [CheckController::class, 'vendorProducts']);

   Route::get('/view-product-details/{id}', [CheckController::class, 'viewProductDetails']);

   Route::get('/vendor-edit-requests', [CheckController::class, 'vendorEditRequests']);

   //users

   Route::resource('users', UserController::class);

   //vendor orders

   Route::get('/my-orders', [VendorOrderController::class, 'myOrders']);
   Route::get('/vendor-order-details/{id}', [VendorOrderController::class, 'vendorOrderDetails']);
   Route::post('edit-order-status', [VendorOrderController::class, 'editOrderStatus']);
   Route::post('/edit-order-place-type', [VendorOrderController::class, 'editOrderPlaceType']);
   
   Route::get('/invoice/{id}', [VendorOrderController::class, 'invoice']);

   //settings
    Route::get('/change-password', [SettingController::class, 'changePassword']);

    Route::post('password-change', [SettingController::class, 'passwordChange']);

    



   //vendor profile
   Route::get('/venodor-profile-settings', [VendorProfileController::class, 'vendorProfileSettings']);
   Route::post('vendor-profile-update', [VendorProfileController::class, 'vendorProfileUpdade']);
   Route::get('/set-delivery-charge', [VendorProfileController::class, 'setDeliveryCharge']);
   Route::post('/save-delivery-charge', [VendorProfileController::class, 'saveDeliveryCharge']);


   //ACL

    Route::get('/add-role', [RoleController::class, 'addRole']);
    Route::get('/role-lists', [RoleController::class, 'roleLists']);
    Route::get('/role-details/{id}', [RoleController::class, 'roleDetails']);
    Route::get('/delete-role/{id}', [RoleController::class, 'deleteRole']);
    Route::post('/save-role', [RoleController::class, 'saveRole']);
    Route::post('/update-role/{id}', [RoleController::class, 'updateRole']);


});


//carts

Route::get('/cart-details', [CartController::class, 'cartDetails']);

Route::post('/save-single-cart', [CartController::class, 'saveSingleCart']);

Route::get('/product-details/{slug}', [DetailController::class, 'productDetails']);

Route::get('/category-details/{slug}', [DetailController::class, 'categoryDetails']);

Route::get('/subcategory-details/{id}', [DetailController::class, 'subcategoryDetails']);

Route::get('/search-product', [DetailController::class, 'searchProduct']);


Route::get('/shop', [DetailController::class, 'shop']);


Route::get('/checkout', [CheckoutController::class, 'checkout']);

Route::post('/save-order', [OrderController::class, 'saveOrder']);

Route::get('/success-order', [OrderController::class, 'successOrder']);

Route::post('/user-signup', [UserAuthController::class, 'userSignup']);

Route::post('/user-signin', [UserAuthController::class, 'userSignin']);

Route::get('/my-account', [UserAuthController::class, 'myAccount']);

Route::post('/user-profile-update', [UserAuthController::class, 'userProfileUpdate']);


Route::get('/user-logout', [UserAuthController::class, 'userLogout']);

Route::get('/user-auth', [UserAuthController::class, 'userAuth']);

Route::get('/my-wishlists', [WishlistController::class, 'myWishlists']); 