<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\TransactionController;

use App\Http\Controllers\FixedCostController;
use App\Http\Controllers\MonthlyCommentController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';

Route::get('/dashboard', [AccountController::class, 'dashboard'])
    ->name('dashboard');

Route::resource('accounts', AccountController::class);

Route::get(
    '/accounts/{account}/edit-balance',
    [AccountController::class, 'editBalance']
)->name('accounts.editBalance');

Route::put(
    '/accounts/{account}/update-balance',
    [AccountController::class, 'updateBalance']
)->name('accounts.updateBalance');

Route::resource('transactions', TransactionController::class);


Route::resource('fixed-costs', FixedCostController::class);


Route::post('/dashboard/comment', [MonthlyCommentController::class, 'saveComment'])
    ->name('dashboard.comment');

Route::post('/comment/delete',[MonthlyCommentController::class, 'deleteComment'])->name('comment.delete');

   
