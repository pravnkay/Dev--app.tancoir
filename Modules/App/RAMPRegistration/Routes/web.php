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

	Route::prefix('rampregistration')
	->name('rampregistration.')
	->group(function () {

		Route::get('/', 							\Modules\App\RAMPRegistration\Actions\RAMPRegistration\Index::class)			->name('index');
		Route::get('/create', 						\Modules\App\RAMPRegistration\Actions\RAMPRegistration\Create::class)			->name('create');
		Route::post('/', 							\Modules\App\RAMPRegistration\Actions\RAMPRegistration\Store::class)			->name('store');
		Route::delete('delete/{registration}',	 	\Modules\App\RAMPRegistration\Actions\RAMPRegistration\Destroy::class)			->name('destroy');

	});

});