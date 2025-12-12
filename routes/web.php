<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;





use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\GovernorateController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Routes
// Admin login routes
// Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
// Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// // Protected routes (only logged-in admins can access)
// Route::middleware('auth:admin')->group(function () {
//     Route::get('admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
//     Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//       // ✅ Admin Category Routes (protected)
//     Route::resource('categories', CategoryController::class);
    
// });

//Admin Category Routes
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::resource('categories', CategoryController::class);
// });

// Admin Routes
// Admin login routes
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Protected routes (only logged-in admins can access)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // ✅ Admin Category Routes (protected)
    Route::resource('categories', CategoryController::class);

    // ✅ Admin Product Routes (protected)
    Route::resource('products', ProductController::class);
    //  Route::delete('products/image/{id}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::delete('products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
 
    Route::delete('products/variant/{id}', [ProductController::class, 'deleteVariant'])
    ->name('products.variant.delete');

   
// Delete variant image (AJAX)
//Route::delete('/admin/products/delete-variant-image/{id}', [ProductController::class, 'deleteVariantImage'])->name('admin.products.deleteVariantImage');

Route::delete('products/delete-variant-image/{id}', [ProductController::class, 'deleteVariantImage'])
    ->name('products.delete-variant-image'); 
    // Admin Order Routes (protected)
    
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);

    // Admin Governorate Routes (protected)
    Route::resource('governorates', GovernorateController::class);


  //  Route::get('/get-products', [ProductController::class, 'getProducts']);

//   Route::get('/admin/products/by-category/{category}', [ProductController::class, 'getByCategory'])
//     ->name('products.byCategory');

Route::get('admin/orders/get-products/{category_id}', 
    [App\Http\Controllers\Admin\OrderController::class, 'getProductsByCategory']
)->name('admin.orders.getProducts');



});
