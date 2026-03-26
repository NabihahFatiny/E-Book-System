<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\NotificationController;

// Routes decide which controller method should run.

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    // Profile management routes for authenticated users.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main user-facing book pages.
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/books/{book}', [UserDashboardController::class, 'show'])->name('books.show');

    // Borrowing flow: borrow a book and open the read page.
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/books/{book}/read', [BorrowingController::class, 'read'])->name('books.read');

    // User borrowing history and returning a borrowed book.
    Route::get('/my-borrowings', [BorrowingController::class, 'index'])->name('my.borrowings');
    Route::patch('/my-borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');

    // Watchlist pages and actions.
    Route::get('/my-watchlist', [WatchlistController::class, 'index'])->name('my.watchlist');
    Route::post('/books/{book}/watchlist', [WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/watchlist/{watchlist}', [WatchlistController::class, 'destroy'])->name('watchlist.destroy');

    // Notification pages and action to mark one notification as read.
    Route::get('/my-notifications', [NotificationController::class, 'index'])->name('my.notifications');
    Route::patch('/my-notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

require __DIR__ . '/auth.php';
