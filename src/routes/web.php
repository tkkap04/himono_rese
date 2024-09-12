<?php

use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;


// ショップ一覧
Route::get('/', [ShopController::class, 'index'])->name('shops.index');

// ログイン・メール認証済み
Route::middleware(['auth', 'verified'])->group(function () {
    // マイページ
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

    // csvインポート画面
    Route::get('/import', [CsvImportController::class, 'import'])->name('import');
    Route::post('/csvImport', [CsvImportController::class, 'csvImport'])->name('csvImport');

    // 店舗詳細画面
    Route::get('/detail/{id}', [ShopController::class, 'detail'])->name('shop.detail');

    // 評価機能
    Route::post('/detail/{shopId}/reviews', [ReviewController::class, 'storeReview'])->name('reviews.store');

    // お気に入り
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{shop}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // 予約操作
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/done', [ReservationController::class, 'done'])->name('reservations.done');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations');
    Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    //QRコード認証
    Route::post('/verify-qr-code', [ReservationController::class, 'verifyQrCode'])->name('verify-qr-code');

    //決済
    route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
});

// 管理者
Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin/create-owner', [AdminController::class, 'showCreateOwnerForm'])->name('admin.create');
    Route::post('/admin/create-owner', [AdminController::class, 'createOwner'])->name('admin.createOwner');
    Route::get('/admin/list', [AdminController::class, 'showList'])->name('admin.list');
    Route::post('/admin/send-email/{user}', [AdminController::class, 'sendEmail'])->name('admin.sendEmail');
    Route::post('/admin/send-email-all', [AdminController::class, 'sendEmailAll'])->name('admin.sendEmailAll');
    Route::get('/admin/edit-email', [AdminController::class, 'editEmail'])->name('admin.editEmail');
    Route::post('/admin/update-email', [AdminController::class, 'updateEmail'])->name('admin.updateEmail');
});

// 店舗代表者
Route::middleware(['middleware' => 'owner'])->group(function () {
    Route::get('/owner/create-shop', [OwnerController::class, 'showCreateShopForm'])->name('owner.create');
    Route::post('/owner/create-shop', [OwnerController::class, 'createShop'])->name('owner.createShop');
    Route::get('/owner/update-shop', [OwnerController::class, 'showUpdateShopForm'])->name('owner.update');
    Route::put('/owner/update-shop', [OwnerController::class, 'updateShop'])->name('owner.updateShop');
    Route::get('/owner/reservations', [OwnerController::class, 'reservations'])->name('owner.reservations');

    Route::get('/owner/create-success', [OwnerController::class, 'showCreateSuccess'])->name('owner.createSuccess');
    Route::get('/owner/update-success', [OwnerController::class, 'showUpdateSuccess'])->name('owner.updateSuccess');

    Route::post('/owner/send-email/{user}', [OwnerController::class, 'sendEmail'])->name('owner.sendEmail');
    Route::post('/owner/send-email-all', [OwnerController::class, 'sendEmailAll'])->name('owner.sendEmailAll');
    Route::get('/owner/edit-email', [OwnerController::class, 'editEmail'])->name('owner.editEmail');
    Route::post('/owner/update-email', [OwnerController::class, 'updateEmail'])->name('owner.updateEmail');
});

// ユーザー登録、ログイン
Route::get('/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/success', function() {
    return view('auth.success');
})->middleware('auth')->name('verification.success');

// ユーザーがメール内のリンクをクリックしたときに処理するルート
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/success');
})->middleware(['auth', 'signed'])->name('verification.verify');

// リクエストされた認証メール再送信
Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
