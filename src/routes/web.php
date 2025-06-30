<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/register', [RegisteredUserController::class, 'showUserRegisterForm'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'registerUser']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/password/change', function () {
    return view('auth.change-password');
})->name('password.change');

Route::post('/password/change', [LoginController::class, 'ChangePassword'])->name('password.update');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('auth.thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/thanks', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return view('auth.thanks');
})->name('auth.thanks');

Route::middleware(['redirect.not.verified'])->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::post('/search', [ShopController::class, 'search'])->name('shop.search');
    Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.detail');
});

Route::middleware(['auth', 'role:1', 'verified'])->group(function () {
    Route::post('/favorite', [ShopController::class, 'toggleFavorite'])->name('shop.favorite');
    Route::post('/reservation', [UserController::class, 'makeReservation'])->name('shop.reservation');
    Route::get('/mypage', [UserController::class, 'showMypage'])->name('mypage');
    Route::get('/qr/{reservation}', [UserController::class, 'showQrCode'])->name('qr.show');
    Route::get('/review', [UserController::class, 'showReviewForm'])->name('reviewed');
    Route::get('/review/create/{reservation}', [UserController::class, 'showCreateReviewForm'])->name('review.create');
    Route::post('/review/store', [UserController::class, 'submitReview'])->name('review.store');
});

Route::middleware(['auth', 'role:2', 'verified', 'password.changed'])->group(function () {
    Route::get('/owner', [OwnerController::class, 'showDashboard'])->name('owner');
    Route::post('/owner/shop/store', [OwnerController::class, 'storeShop'])->name('owner.shop.store');
    Route::put('/owner/shop/{shop}/modify', [OwnerController::class, 'updateShop'])->name('owner.shop.modify');
    Route::get('/notify/form', [OwnerController::class, 'showNotifyForm'])->name('notify.form');
    Route::post('/notify/confirm', [OwnerController::class, 'confirmNotify'])->name('notify.confirm');
    Route::post('/notify/send', [OwnerController::class, 'sendNotify'])->name('notify.send');
    Route::get('/visit/verify/{token}', [OwnerController::class, 'verifyVisit'])->name('visit.verify');
    Route::post('/visit/mark/{reservation}', [OwnerController::class, 'markVisited'])->name('visit.mark');
});

Route::middleware(['auth', 'role:3', 'verified'])->group(function () {
    Route::get('/admin/register', [RegisteredUserController::class, 'showAdminRegisterForm'])->name('show.admin.register');
    Route::post('/admin/register', [RegisteredUserController::class, 'registerAdmin'])->name('admin.register');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::delete('/reservation/{id}', [UserController::class, 'cancelReservation'])->name('reservation.destroy');
    Route::put('/reservation/{id}', [UserController::class, 'updateReservation'])->name('reservation.update');
});