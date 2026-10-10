<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ForgotPasswordController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\TabbyWebhookController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware('nocache')->name('home');
Route::get('register/', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('terms', [HomeController::class, 'terms'])->name('terms');
Route::get('privacy-policy', [HomeController::class, 'privacy'])->name('privacy-policy');
Route::get('return-policy', [HomeController::class, 'returnPolicy'])->name('return-policy');
Route::get('warranty-policy', [HomeController::class, 'warrantyPolicy'])->name('warranty-policy');
Route::get('cookie-policy', [HomeController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('shipping-policy', [HomeController::class, 'shippingPolicy'])->name('shipping-policy');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact-submit', [HomeController::class, 'submitContactForm'])->name('contact.submit');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('/blogs', [BlogController::class, 'blogs'])
    ->name('blogs');
Route::get('/blogs/{slug}', [BlogController::class, 'blogDetails'])
    ->name('blogs.details');

Route::get('forgot-password/', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.sendResetLink');
Route::get('/password/reset/{email}/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::get('/home', [HomeController::class, 'index']);

Route::group(['middleware' => ['auth:frontend', 'nocache']], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('account', [ProfileController::class, 'getUserAccountInfo'])->name('account');
    Route::post('/account/update', [ProfileController::class, 'update'])->name('account.update');
    Route::get('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('account.changePassword');
    Route::get('my-address', [ProfileController::class, 'getUserAddressInfo'])->name('my-address');
    Route::post('save-address', [ProfileController::class, 'saveAddress'])->name('save-address');
    Route::post('/address/delete', [ProfileController::class, 'deleteAddress'])->name('delete-address');
    Route::get('edit-address/{id}', [ProfileController::class, 'editAddress'])->name('edit-address');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');
    Route::get('/notifications', [NotificationController::class, 'customerNotifications'])
        ->name('customer.notifications');
    Route::post('/notification/read/{id}', [NotificationController::class, 'markRead'])
        ->name('notification.read');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('reviews.save');
});

Route::get(
    '/payment/tabby/success',
    [CheckoutController::class, 'tabbySuccess']
)->name('tabby.success');

Route::get(
    '/payment/tabby/cancel',
    [CheckoutController::class, 'tabbyCancel']
)->name('tabby.cancel');

Route::post(
    'webhooks/tabby',
    [TabbyWebhookController::class, 'handle']
)->name('tabby.webhook');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');

Route::fallback(function () {
    return response()->view('frontend.errors.404', [], 404);
});
