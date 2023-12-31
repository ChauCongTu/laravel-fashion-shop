<?php

use App\Http\Controllers\Admin\BannerManagementController;
use App\Http\Controllers\Admin\BrandManagementController;
use App\Http\Controllers\Admin\CategoriesManagementController;
use App\Http\Controllers\Admin\CouponManagementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\PostManagementController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Export\PDFController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Models\Order;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/{slug}-{id}.cat', [CategoriesController::class, 'show'])->where(['slug' => '.+', 'id' => '[0-9]+'])->name('category.show');

Route::get('^/{slug}-{id}', [ProductController::class, 'show'])->where(['slug' => '.+', 'id' => '[0-9]+'])->name('product.show');

Route::post('/comment/{reply_id?}', [ProductController::class, 'comment'])->name('product.comment');

Route::get('/dang-nhap', [LoginController::class, 'login'])->name('login');
Route::post('/dang-nhap', [LoginController::class, 'handle'])->name('login');
Route::get('/dang-ky', [RegisterController::class, 'register'])->name('register');
Route::post('/dang-ky', [RegisterController::class, 'handle'])->name('register');
// Route::get('/quen-mat-khau', [ResetPasswordController::class, 'getReset'])->name('reset');
// Route::post('/quen-mat-khau', [ResetPasswordController::class, 'postReset'])->name('reset');
Route::get('/logout', function () {
    auth()->logout();

    return redirect(route('home'));
})->name('logout');

Route::get('/gio-hang', [CartController::class, 'index'])->name('cart');
Route::post('/them-vao-gio-hang/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cap-nhat-gio-hang', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/ap-dung-coupon', [CartController::class, 'applyCoupon'])->middleware('login')->name('cart.coupon');
Route::get('/thanh-toan', [CheckoutController::class, 'getCheckout'])->middleware('login')->name('cart.checkout');
Route::post('/thanh-toan', [CheckoutController::class, 'postCheckout'])->middleware('login')->name('cart.checkout');
Route::get('vnpay_payment', [CheckoutController::class, 'vnpay_payment'])->middleware('login')->name('vnpay');
Route::get('thanh-toan-thanh-cong', [CheckoutController::class, 'finishPayment'])->middleware('login')->name('vnpay.success');
Route::post('/cancel/{code}', [CheckoutController::class, 'cancelOrder'])->middleware('login')->name('cart.cancel');
Route::get('/destroy-cart', function () {
    session()->forget('cart');
    return redirect()->back()->with('msg', 'Hủy bỏ giỏ hàng thành công');
})->name('cart.destroy');

Route::prefix('wishlist')->middleware('login')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/remove-from-wishlist/{product_id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

Route::middleware('login')->group(function () {
    Route::get('/tai-khoan-cua-toi.html', [UserController::class, 'myInfo'])->name('users.info');
    Route::post('/tai-khoan-cua-toi.html', [UserController::class, 'editInfo'])->name('users.info');
    Route::post('/doi-anh-dai-dien', [UserController::class, 'changeAvatar'])->name('users.change_avatar');
    Route::get('/don-hang-cua-toi', [UserController::class, 'myOrder'])->name('user.orders');
    Route::get('/chi-tiet-don-hang/{code}.html', [UserController::class, 'orderDetail'])->name('user.orders.detail');
    Route::put('/status/{code}/change/', [CheckoutController::class, 'updateStatus'])->name('user.orders.changeStatus');
});

Route::get('tim-kiem', [SearchController::class, 'search'])->name('search');
Route::prefix('blog')->group(function () {
    Route::get('/', [PostController::class, 'list'])->name('post.list');
    Route::get('/{slug}-{id}', [PostController::class, 'show'])->where(['slug' => '.+', 'id' => '[0-9]+'])->name('post.show');
});

// Admin Route
Route::prefix('/admin')->middleware('adminCheck')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('admin');
    Route::resource('/quan-ly-danh-muc', CategoriesManagementController::class);
    Route::put('updateDiscount/{id}', [ProductManagementController::class, 'updateDiscount'])->name('product.changeDiscount');
    Route::put('updateStock/{id}', [ProductManagementController::class, 'updateStock'])->name('product.changeStock');
    Route::get('/hinh-anh/{product_id}', [ProductManagementController::class, 'image'])->name('product.image');
    Route::post('/hinh-anh/{product_id}/them', [ProductManagementController::class, 'addImage'])->name('product.image.add');
    Route::delete('/hinh-anh/{id}/xoa', [ProductManagementController::class, 'deleteImage'])->name('product.image.delete');
    Route::resource('/quan-ly-san-pham', ProductManagementController::class);
    Route::prefix('/quan-ly-don-hang')->group(function () {
        Route::get('/', [OrderManagementController::class, 'index'])->name('admin.order');
        Route::put('updateStatus/{id}', [OrderManagementController::class, 'updateStatus'])->name('admin.order.changStatus');
    });
    Route::get('create-pdf-file/{id}', [PDFController::class, 'index'])->name('admin.order.export');
    Route::resource('/ma-giam-gia', CouponManagementController::class);
    Route::resource('/quan-ly-thuong-hieu', BrandManagementController::class);
    Route::resource('/quan-ly-banner', BannerManagementController::class);
    Route::resource('quan-ly-bai-viet', PostManagementController::class);
    Route::resource('quan-ly-nguoi-dung', UserManagementController::class);
    Route::put('changeRole/{id}', [UserManagementController::class, 'changeRole'])->name('quan-ly-nguoi-dung.changeRole');
    Route::put('banUser/{id}', [UserManagementController::class, 'banUser'])->name('quan-ly-nguoi-dung.banUser');
});
// Route::post('/getRevenue', [DashboardController::class, 'getRevenue']);
