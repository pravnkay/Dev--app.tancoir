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

		Route::prefix('apply')
		->name('apply.')
		->group(function () {

			Route::get('/',				\Modules\Registry\RAMP\Actions\Apply\Index::class)						->name('index');
			Route::get('/{event}',		\Modules\Registry\RAMP\Actions\Apply\Create::class)						->name('create');

		});

	});

});