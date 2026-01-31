<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\DashboardController;


use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CategoryController as CustomerCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes

// Route::get('/', function () {
//     return view('customer.home.index');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories/{slug}', [CustomerCategoryController::class, 'show'])
    ->name('categories.show');

    Route::get('/categories', [CustomerCategoryController::class, 'index'])
        ->name('categories.index');



// User dashboard (authenticated)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin login (public)
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Admin protected routes
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Categories
    //Route::resource('categories', CategoryController::class);
    Route::resource('categories', AdminCategoryController::class);
    // Products
    Route::resource('products', ProductController::class);
    Route::delete('products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::delete('products/variant/{id}', [ProductController::class, 'deleteVariant'])->name('products.variant.delete');
    Route::delete('products/delete-variant-image/{id}', [ProductController::class, 'deleteVariantImage'])->name('products.delete-variant-image');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::get('orders/get-products/{category_id}', [OrderController::class, 'getProductsByCategory'])->name('orders.getProducts');
    Route::delete('orders/item/{item}', [OrderController::class, 'deleteItem'])->name('orders.deleteItem');
    Route::post('orders/{order}/add-item', [OrderController::class, 'addItem'])->name('orders.addItem');

    // Governorates
    Route::resource('governorates', GovernorateController::class);
});
