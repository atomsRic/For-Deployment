<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// ─── Public Home ─────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── Authenticated Routes ────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::resource('users', UserController::class)
     ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']); 

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── Borrow Routes ───────────────────────────────────────
    Route::get('/borrows',               [BorrowController::class, 'index'])->name('borrows.index');
    Route::get('/borrows/create',        [BorrowController::class, 'create'])->name('borrows.create');
    Route::post('/borrows',              [BorrowController::class, 'store'])->name('borrows.store');
    Route::get('/borrows/{borrow}/edit', [BorrowController::class, 'edit'])->name('borrows.edit');
    Route::put('/borrows/{borrow}',      [BorrowController::class, 'update'])->name('borrows.update');

    // ─── Books Routes (Public Access) ────────────────────────

    // View all books
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // ─── Admin-only Book Routes ──────────────────────────────
    Route::middleware(['role:admin'])->group(function () {

        // IMPORTANT: Specific routes FIRST
        Route::get('/books/create',      [BookController::class, 'create'])->name('books.create');
        Route::post('/books',            [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}',      [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}',   [BookController::class, 'destroy'])->name('books.destroy');

    });

    // wildcard route
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

});

// ─── Admin Borrow Delete ─────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/borrows/{borrow}', [BorrowController::class, 'destroy'])->name('borrows.destroy');
});

// ─── Breeze Auth Routes ──────────────────────────────────────
require __DIR__ . '/auth.php';