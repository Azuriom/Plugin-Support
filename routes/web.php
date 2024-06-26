<?php

use Azuriom\Plugin\Support\Controllers\CategoryTicketController;
use Azuriom\Plugin\Support\Controllers\CommentAttachmentController;
use Azuriom\Plugin\Support\Controllers\TicketCommentController;
use Azuriom\Plugin\Support\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::redirect('/', '/support/tickets');

Route::middleware('auth')->group(function () {
    Route::post('/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::post('/{ticket}/open', [TicketController::class, 'open'])->name('tickets.open');
    Route::resource('category.tickets', CategoryTicketController::class)->only(['create', 'store']);
    Route::resource('tickets', TicketController::class)->except(['store', 'edit', 'destroy']);
    Route::resource('tickets.comments', TicketCommentController::class)->only(['store', 'update', 'destroy']);
    Route::post('comments/attachments/{pendingId}', [CommentAttachmentController::class, 'pending'])
        ->name('comments.attachments.pending');
});
