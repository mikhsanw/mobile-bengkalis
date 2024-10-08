<?php

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
|
*/

use Illuminate\Support\Facades\Route;

Route::get(config('master.aplikasi.author').'/{folder}/{file}', 'jsController@backend');
Route::get(config('master.aplikasi.author').'/{folder}/{id}/{file}', 'jsController@backendWithId');
Route::get(config('master.aplikasi.author').'/{folder}/{link}/{kode}/{file}', 'jsController@backendWithKode');

Route::get('/home', 'berandaController@index')->name('beranda.home');
Route::group(['prefix' => config('master.url.admin')], function () {
	// dashboard - beranda
	Route::get('/', 'berandaController@index')->name('beranda.index');

	// Url Public
    Route::group(['middleware' => ['throttle:5']], function () {
		Route::post('lock-screen', 'userController@lockScreen');
    });
	//user ubah password
	Route::get('user/ubahpassword/{id}', 'userController@ubahpassword')->name('user.ubahpassword');
	Route::group(['middleware' => ['throttle:10']], function () {
		Route::post('user/ubahpassword', 'userController@resetpassword')->name('user.store_ubahpassword');
	});
	Route::group(['middleware' => ['aksesmenu']], function () {
        //user
        Route::get('user/hapus/{id}', 'userController@hapus')->name('user.hapus');
        Route::get('user/data', 'userController@data')->name('user.data');
        Route::resource('user', 'userController');
        //menu
        Route::get('menu/hapus/{id}', 'menuController@hapus')->name('menu.hapus');
        Route::get('menu/data', 'menuController@data')->name('menu.data');
        Route::post('menu/susun-menu', 'menuController@susunMenu')->name('menu.susun-menu');
        Route::get('menu/extract-menu', 'menuController@extract')->name('menu.extract-menu');
        Route::resource('menu', 'menuController');
        //aksesgrup
        Route::get('aksesgrup/hapus/{id}', 'aksesgrupController@hapus')->name('aksesgrup.hapus');
        Route::get('aksesgrup/data', 'aksesgrupController@data')->name('aksesgrup.data');
        Route::get('aksesgrup/detail/data/{id}', 'aksesgrupController@data_detail')->name('aksesgrup.data_detail');
        Route::resource('aksesgrup', 'aksesgrupController');
        //aksesmenu
        Route::get('aksesmenu/data/{id}', 'aksesmenuController@data')->name('aksesmenu.data');
        Route::get('aksesmenu/create/{id}', 'aksesmenuController@create')->name('aksesmenu.create_id');
        Route::resource('aksesmenu', 'aksesmenuController');
        
        // slider
        Route::prefix('slider')->as('slider')->group(function () {
            Route::get('/data', 'sliderController@data');
            Route::get('/hapus/{id}', 'sliderController@hapus');
        });
        Route::resource('slider', 'sliderController');

        // kontak
        Route::prefix('kontak')->as('kontak')->group(function () {
            Route::get('/data', 'kontakController@data');
            Route::get('/hapus/{id}', 'kontakController@hapus');
        });
        Route::resource('kontak', 'kontakController');
        
        // posts
        Route::prefix('posts')->as('posts')->group(function () {
            Route::get('/data', 'PostsController@data');
            Route::get('/hapus/{id}', 'PostsController@hapus');
        });
        Route::resource('posts', 'PostsController');

        // aplikasi
        Route::prefix('aplikasi')->as('aplikasi')->group(function () {
            Route::get('/data/{id?}', 'aplikasiController@data');
            Route::get('/logo/{id}', 'aplikasiController@logo');
            Route::post('/store_logo', 'aplikasiController@store_logo');
            Route::get('/favicon/{id}', 'aplikasiController@favicon');
            Route::post('/store_favicon', 'aplikasiController@store_favicon');
        });
        Route::resource('aplikasi', 'aplikasiController');   

    	Route::prefix('opds')->as('opds')->group(function () {
			Route::get('/data', 'OpdsController@data');
			Route::get('/hapus/{id}', 'OpdsController@hapus');
		});
		Route::resource('opds', 'OpdsController');

		Route::prefix('aplikasis')->as('aplikasis')->group(function () {
			Route::get('/data', 'AplikasisController@data');
			Route::get('/hapus/{id}', 'AplikasisController@hapus');
		});
		Route::resource('aplikasis', 'AplikasisController');

		Route::prefix('aplikasipemdas')->as('aplikasipemdas')->group(function () {
			Route::get('/data', 'AplikasiPemdasController@data');
			Route::get('/hapus/{id}', 'AplikasiPemdasController@hapus');
		});
		Route::resource('aplikasipemdas', 'AplikasiPemdasController');

		Route::prefix('beritas')->as('beritas')->group(function () {
			Route::get('/data', 'BeritasController@data');
			Route::get('/hapus/{id}', 'BeritasController@hapus');
		});
		Route::resource('beritas', 'BeritasController');

		Route::prefix('permohonans')->as('permohonans')->group(function () {
			Route::get('/data', 'PermohonansController@data');
			Route::get('/hapus/{id}', 'PermohonansController@hapus');
		});
		Route::resource('permohonans', 'PermohonansController');

		Route::prefix('datainformasis')->as('datainformasis')->group(function () {
			Route::get('/data', 'DataInformasisController@data');
			Route::get('/hapus/{id}', 'DataInformasisController@hapus');
		});
		Route::resource('datainformasis', 'DataInformasisController');

		Route::prefix('kims')->as('kims')->group(function () {
			Route::get('/data', 'KimsController@data');
			Route::get('/hapus/{id}', 'KimsController@hapus');
			Route::get('/get_kelurahan/{kecamatan_id}', 'KimsController@getKelurahan');
		});
		Route::resource('kims', 'KimsController');

		Route::prefix('kegiatankims')->as('kegiatankims')->group(function () {
			Route::get('/data', 'KegiatanKimsController@data');
			Route::get('/hapus/{id}', 'KegiatanKimsController@hapus');
		});
		Route::resource('kegiatankims', 'KegiatanKimsController');
		
		Route::prefix('kimanggota')->as('kimanggota')->group(function () {
			Route::get('/data', 'KimAnggotaController@data');
			Route::get('/hapus/{id}', 'KimAnggotaController@hapus');
		});
		Route::resource('kimanggota', 'KimAnggotaController');

		Route::prefix('products')->as('products')->group(function () {
			Route::get('/data', 'ProductsController@data');
			Route::get('/hapus/{id}', 'ProductsController@hapus');
		});
		Route::resource('products', 'ProductsController');

	});
});
