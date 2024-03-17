<?php

declare(strict_types=1);

use App\Domain\Event\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::post('/create', [EventController::class, 'create'])->name('create');
Route::get('/interval', [EventController::class, 'getAllBetweenDate'])->name('interval');
Route::get('/location', [EventController::class, 'getAllEventLocationsByDateInterval'])->name('location');

Route::prefix('{event}')->group(function () {
    Route::get('/', [EventController::class, 'get'])->name('get');
    Route::delete('/', [EventController::class, 'delete'])->name('delete');
    Route::put('/', [EventController::class, 'update'])->name('update');
})->whereUuid('event');
