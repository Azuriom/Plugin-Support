<?php

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

Route::middleware('auth')->group(function () {
    Route::post('/{ticket}/close', 'TicketController@close')->name('tickets.close');
    Route::resource('tickets', 'TicketController')->except(['edit', 'destroy']);
    Route::resource('tickets.comments', 'TicketCommentController')->only(['store', 'update', 'destroy']);
});
