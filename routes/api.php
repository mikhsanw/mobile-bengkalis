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
Route::post('/storepermohonan', 'Api\AppSiterubukController@storepermohonan');
Route::post('/opd', 'Api\AppSiterubukController@opd');
Route::post('/datainformasi', 'Api\AppSiterubukController@datainformasi');
Route::post('/tentang', 'Api\AppSiterubukController@tentang');


Route::prefix('kim')->as('kim')->group(function () {
    Route::post('/login', 'Api\KimController@login');
    Route::group(['middleware'=>['auth:sanctum']], function () {
    //api kim bermasa
        Route::post('/dashboard', 'Api\KimController@dashboard');
        Route::post('/store_kegiatan', 'Api\KimController@store');
        Route::post('/kegiatan', 'Api\KimController@getkimkegiatan');
        Route::post('/tentang', 'Api\KimController@tentang');
    });
});
