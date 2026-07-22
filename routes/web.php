<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\FixedCostController;
use App\Http\Controllers\MonthlyCommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login'); // ログイン画面にリダイレクトさせる
});

Route::get('/dashboard', [AccountController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 認証済み（ログイン中）ユーザー用のルートグループ
Route::middleware(['auth'])->group(function () {

    // プロフィール管理
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 👇 【追加】口座残高の編集・更新処理ルート（Resourceより上に記述します）
    Route::get('accounts/{account}/edit-balance', [AccountController::class, 'editBalance'])->name('accounts.editBalance');
    Route::patch('accounts/{account}/update-balance', [AccountController::class, 'updateBalance'])->name('accounts.updateBalance');

    // 各リソース管理（取引・口座・固定費）
    Route::resource('transactions', TransactionController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('fixed_costs', FixedCostController::class);

    // コメント
    Route::pattern('month', '\d{4}-\d{2}');

    Route::get('/monthly-summaries/{month}/comments', [MonthlyCommentController::class, 'index'])
        ->name('monthly-comments.index');
    Route::post('/monthly-summaries/{month}/comments', [MonthlyCommentController::class, 'store'])
        ->name('monthly-comments.store');
    Route::delete('/monthly-comments/{monthlyComment}', [MonthlyCommentController::class, 'destroy'])
        ->name('monthly-comments.destroy');
});

require __DIR__ . '/auth.php';
