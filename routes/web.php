<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\DashboardController;

// Customer Controllers
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CategoryController as CustomerCategoryController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes


Route::get('/', [HomeController::class, 'index'])->name('home');
//customer  Categories
Route::get('/categories/{slug}', [CustomerCategoryController::class, 'show'])
    ->name('categories.show');
    Route::get('/categories', [CustomerCategoryController::class, 'index'])
        ->name('categories.index');

  //customer  Products
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');        // all products page
Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show'); // product details

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update', [CartController::class, 'update'])->name('update'); // set quantity
    Route::post('/increment', [CartController::class, 'increment'])->name('increment');
    Route::post('/decrement', [CartController::class, 'decrement'])->name('decrement');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');

    // optional for ajax badge
    Route::get('/count', [CartController::class, 'count'])->name('count');
});
/*
|--------------------------------------------------------------------------
| Checkout / Orders (Customer)
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order:order_code}', [CheckoutController::class, 'success'])->name('checkout.success');

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
    Route::resource('products', AdminProductController::class);
    Route::delete('products/delete-image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::delete('products/variant/{id}', [AdminProductController::class, 'deleteVariant'])->name('products.variant.delete');
    Route::delete('products/delete-variant-image/{id}', [AdminProductController::class, 'deleteVariantImage'])->name('products.delete-variant-image');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::get('orders/get-products/{category_id}', [OrderController::class, 'getProductsByCategory'])->name('orders.getProducts');
    Route::delete('orders/item/{item}', [OrderController::class, 'deleteItem'])->name('orders.deleteItem');
    Route::post('orders/{order}/add-item', [OrderController::class, 'addItem'])->name('orders.addItem');

    // Governorates
    Route::resource('governorates', GovernorateController::class);
});
