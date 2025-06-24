<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\RegisteredUserController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

Route::get('/register', [RegisteredUserController::class, 'showUserRegisterForm'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'registerUser']);



Route::get('/email/verify', function () {
    return view('auth.verify-email'); // 認証を促すページ
})->middleware('auth')->name('verification.notice');

// 認証リンクからの遷移先（idとハッシュを含む）
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // メール認証済にする
    return redirect()->route('auth.thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送信処理
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/thanks', function (Request $request) {
    Auth::logout(); // ログアウト実行
    $request->session()->invalidate();       // セッションを無効化
    $request->session()->regenerateToken();  // CSRFトークンを再生成

    return view('auth.thanks'); // thanksページ表示
})->name('auth.thanks');


Route::middleware(['redirect.not.verified'])->group(function () {
    Route::get('/', [ContentsController::class, 'index'])->name('shop.index');
    Route::post('/search', [ContentsController::class, 'search'])->name('shop.search');
    Route::get('/detail/{shop_id}', [ContentsController::class, 'show'])->name('shop.detail');
    Route::post('/favorite', [ContentsController::class, 'favorite'])->name('shop.favorite');
});

// 一般ユーザー (role = 1)
Route::middleware(['auth', 'role:1', 'verified'])->group(function () {
    Route::post('/reservation', [ContentsController::class, 'reservation'])->name('shop.reservation');
    Route::get('/mypage', [ContentsController::class, 'mypage'])->name('mypage');
    Route::get('/qr/{reservation}', [ContentsController::class, 'displayQr'])->name('qr.show');
    Route::get('/review', [App\Http\Controllers\ContentsController::class, 'reviewed'])->name('reviewed');
    Route::get('/review/create/{reservation}', [App\Http\Controllers\ContentsController::class, 'create'])->name('review.create');
    Route::post('/review/store', [App\Http\Controllers\ContentsController::class, 'store'])->name('review.store');
});

// 店舗代表者 (role = 2)
Route::middleware(['auth', 'role:2' ,'verified'])->group(function () {
    Route::get('/owner', [ContentsController::class, 'owner'])->name('owner');
    Route::post('/owner/shop/store', [ContentsController::class, 'storeShop'])->name('owner.shop.store');
    Route::put('/owner/shop/{shop}/modify', [ContentsController::class, 'modifyShop'])->name('owner.shop.modify');
    Route::get('/notify/form', [ContentsController::class, 'showForm'])->name('notify.form');
    Route::post('/notify/confirm', [ContentsController::class, 'confirm'])->name('notify.confirm');
    Route::post('/notify/send', [ContentsController::class, 'send'])->name('notify.send');
    Route::get('/visit/verify/{token}', [ContentsController::class, 'verify'])->name('visit.verify');
    Route::post('/visit/mark/{reservation}', [ContentsController::class, 'mark'])->name('visit.mark');
});

// 管理者 (role = 3)
Route::middleware(['auth', 'role:3' ,'verified'])->group(function () {
    Route::get('/admin/register', [RegisteredUserController::class, 'showAdminRegisterForm'])->name('show.admin.register');
    Route::post('/admin/register', [RegisteredUserController::class, 'registerAdmin'])->name('admin.register');
});

// 全ロールのユーザ
Route::middleware(['auth', 'verified'])->group(function () {

    Route::delete('/reservation/{id}', [ContentsController::class, 'destroy'])->name('reservation.destroy');

    Route::put('/reservation/{id}', [ContentsController::class, 'update'])->name('reservation.update');
});