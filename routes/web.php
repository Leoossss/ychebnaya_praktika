<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MotorcycleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Публичная часть магазина
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/motorcycle/{motorcycle}', [ShopController::class, 'show'])->name('show');
    
    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{motorcycle}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Оформление заказа
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
});

// Webhook ЮMoney
Route::post('/webhook/yoomoney', [CheckoutController::class, 'yoomoneyWebhook']);

// Личный кабинет
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// АДМИН-ПАНЕЛЬ
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Новый Dashboard с красивой статистикой
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('motorcycles', MotorcycleController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

require __DIR__.'/auth.php';