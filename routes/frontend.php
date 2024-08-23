<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/
use Illuminate\Support\Facades\Route;

// Route::get('/', 'frontendController@index');
Route::get('/privacy-policy', 'frontendController@privacy')->name('privacy-policy');