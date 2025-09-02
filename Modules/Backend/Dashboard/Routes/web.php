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

Route::middleware(['auth', 'verified', 'role:admin'])
->prefix('backend')
->name('backend.')
->group(function () {

	Route::get('/', function() {
		return view('dashboard::dashboard.index');
	})->name('dashboard');

	Route::prefix('bulk')
	->name('bulk.')
	->group(function () {

		Route::prefix('import')
		->name('import.')
		->group(function () {

			Route::get('/{model}', 				\Modules\Backend\Dashboard\Actions\Bulk\Importer\Create::class)			->name('create');
			Route::post('/',		 			\Modules\Backend\Dashboard\Actions\Bulk\Importer\Store::class)			->name('store');

		});
			
		Route::delete('/delete', 				\Modules\Backend\Dashboard\Actions\Bulk\Destroyer\Destroy::class)		->name('destroy');


	});

});