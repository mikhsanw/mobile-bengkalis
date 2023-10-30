<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/berita', 'Api\SuperappsController@berita');
Route::post('/aplikasipemda', 'Api\SuperappsController@aplikasipemda');
Route::post('/cariaplikasipemda', 'Api\SuperappsController@cariaplikasipemda');
Route::get('/hapus/{id}', 'Backend\OpdsController@hapus');

//api siterubuk
Route::post('/permohonan/store', 'Api\AppSiterubukController@store');

