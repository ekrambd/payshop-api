<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\VendorOrderController;

Route::post('slider-status-update', [SliderController::class, 'sliderStatusUpdate']);
Route::post('category-status-update', [CategoryController::class, 'categoryStatusUpdate']);
Route::post('/subcategory-status-change', [SubcategoryController::class, 'subcategoryStatusChange']);
Route::post('add-to-cart', [CartController::class, 'addToCart']);
Route::post('/update-cart', [CartController::class, 'updateCart'])
    ->name('update.cart');
Route::post('/add-to-wishlist', [CartController::class, 'addToWishList']);
Route::get('/delete-cart/{id}', [CartController::class, 'deleteCart']);
Route::get('/variant-details/{id}', [CartController::class, 'variantDetails']);
Route::post('/vendor-status-update', [CheckController::class, 'vendorStatusUpdate']);
Route::get('/delete-vendor/{id}', [CheckController::class, 'deleteVendor']);
Route::post('/product-status-verify', [CheckController::class, 'productStatusVerify']);
Route::post('/vendor-request-status/{id}', [CheckController::class, 'vendorRequestStatus']);
Route::post('/orders-status-change', [VendorOrderController::class, 'orderStatusChange']);
Route::get('/delete-variant/{id}', [CheckController::class, 'deleteVariant']);
Route::post('/subcategories-by-category', [SubcategoryController::class, 'subcategoriesByCategory']);