<?php

declare(strict_types=1);

use App\Domain\Event\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::put('/create', [EventController::class, 'create'])->name('create');
Route::post('/interval', [EventController::class, 'getAllForDate'])->name('interval');
