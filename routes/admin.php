<?php

Route::resource('categories', 'CategoryController')->except(['index', 'show']);

Route::post('/{ticket}/close', 'TicketController@close')->name('tickets.close');
Route::post('/{ticket}/open', 'TicketController@open')->name('tickets.open');
Route::resource('tickets', 'TicketController')->except(['edit', 'create', 'store']);

Route::resource('tickets.comments', 'TicketCommentController')->only(['store', 'update', 'destroy']);
