<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\WatchlistController;


Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/books/{book}', [UserDashboardController::class, 'show'])->name('books.show');

    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/books/{book}/read', [BorrowingController::class, 'read'])->name('books.read');
    Route::post('/books/{book}/watch', [WatchlistController::class, 'store'])->name('watchlist.store');

    Route::get('/my-borrowings', [BorrowingController::class, 'index'])->name('my.borrowings');

    Route::patch('/my-borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
});

require __DIR__ . '/auth.php';
