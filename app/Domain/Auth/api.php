<?php

declare(strict_types=1);

// Authentication routes
use App\Domain\Auth\Controllers\AuthenticationController;

Route::middleware('guest')->group(function (): void {
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
});

// Authenticated routes
Route::middleware(['auth:api'])->group(function (): void {
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});
