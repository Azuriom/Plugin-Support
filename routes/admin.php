<?php

use Azuriom\Plugin\Support\Controllers\Admin\CategoryController;
use Azuriom\Plugin\Support\Controllers\Admin\SettingsController;
use Azuriom\Plugin\Support\Controllers\Admin\TicketCommentController;
use Azuriom\Plugin\Support\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:support.categories')->group(function () {
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::resource('categories', CategoryController::class)->except(['index', 'show']);
});

Route::middleware('can:support.tickets')->group(function () {
    Route::post('/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::post('/{ticket}/open', [TicketController::class, 'open'])->name('tickets.open');
    Route::resource('tickets', TicketController::class)->except(['edit', 'create', 'store']);

    Route::resource('tickets.comments', TicketCommentController::class)->only(['store', 'update', 'destroy']);
});
