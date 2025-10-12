<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified', 'role:user'])
->prefix('app')
->name('app.')
->group(function () {

	Route::prefix('ramp')
	->name('ramp.')
	->group(function () {

		Route::prefix('registration')
		->name('registration.')
		->group(function () {

			Route::get('/', 							\Modules\App\RAMP\Actions\Registration\Index::class)			->name('index');
			Route::get('/create', 						\Modules\App\RAMP\Actions\Registration\Create::class)			->name('create');
			Route::post('/', 							\Modules\App\RAMP\Actions\Registration\Store::class)			->name('store');

		});
	
	});

});