<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', [ContentController::class, 'about'])->name('about');
Route::get('/contacts', [ContactController::class, 'show'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/search', [CatalogController::class, 'search'])->name('catalog.search');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/articles', [ContentController::class, 'articles'])->name('articles.index');
Route::get('/articles/{article:slug}', [ContentController::class, 'article'])->name('articles.show');
Route::get('/promotions', [ContentController::class, 'promotions'])->name('promotions.index');
Route::get('/reviews', [ContentController::class, 'reviews'])->name('reviews.index');
Route::post('/reviews/{product:slug?}', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/promo-code', [CartController::class, 'applyPromo'])->name('cart.promo');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('account')->name('account.')->group(function (): void {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::patch('/', [AccountController::class, 'update'])->name('update');
    Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('addresses.store');
    Route::post('/favorites/{product}', [AccountController::class, 'toggleFavorite'])->name('favorites.toggle');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
    Route::get('/content', [AdminContentController::class, 'index'])->name('content.index');
    Route::post('/content/articles', [AdminContentController::class, 'storeArticle'])->name('content.articles.store');
    Route::post('/content/promotions', [AdminContentController::class, 'storePromotion'])->name('content.promotions.store');
    Route::post('/content/promo-codes', [AdminContentController::class, 'storePromoCode'])->name('content.promo-codes.store');
    Route::patch('/content/reviews/{review}/approve', [AdminContentController::class, 'approveReview'])->name('content.reviews.approve');
    Route::delete('/content/reviews/{review}', [AdminContentController::class, 'destroyReview'])->name('content.reviews.destroy');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
