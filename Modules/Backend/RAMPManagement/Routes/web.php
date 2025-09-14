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

	Route::prefix('rampmanagement')
	->name('rampmanagement.')
	->group(function () {

		Route::prefix('dashboard')
		->name('dashboard.')
		->group(function () {

			Route::get('/', 					\Modules\Backend\RAMPManagement\Actions\Dashboard\Index::class)			->name('index');

		});

		Route::prefix('verticals')
		->name('verticals.')
		->group(function () {

			Route::get('/', 					\Modules\Backend\RAMPManagement\Actions\Verticals\Index::class)			->name('index');
			Route::get('/create', 				\Modules\Backend\RAMPManagement\Actions\Verticals\Create::class)		->name('create');
			Route::post('/', 					\Modules\Backend\RAMPManagement\Actions\Verticals\Store::class)			->name('store');
			Route::get('/{vertical}/edit', 		\Modules\Backend\RAMPManagement\Actions\Verticals\Edit::class)			->name('edit');
			Route::put('/{vertical}', 			\Modules\Backend\RAMPManagement\Actions\Verticals\Update::class)		->name('update');
			Route::delete('/{vertical}', 		\Modules\Backend\RAMPManagement\Actions\Verticals\Destroy::class)		->name('destroy');

		});

		Route::prefix('programmes')
		->name('programmes.')
		->group(function () {

			Route::get('/', 					\Modules\Backend\RAMPManagement\Actions\Programmes\Index::class)		->name('index');
			Route::get('/create', 				\Modules\Backend\RAMPManagement\Actions\Programmes\Create::class)		->name('create');
			Route::post('/', 					\Modules\Backend\RAMPManagement\Actions\Programmes\Store::class)		->name('store');
			Route::get('/{programme}/edit', 	\Modules\Backend\RAMPManagement\Actions\Programmes\Edit::class)			->name('edit');
			Route::put('/{programme}', 			\Modules\Backend\RAMPManagement\Actions\Programmes\Update::class)		->name('update');
			Route::delete('/{programme}', 		\Modules\Backend\RAMPManagement\Actions\Programmes\Destroy::class)		->name('destroy');

		});

		Route::prefix('events')
		->name('events.')
		->group(function () {

			Route::get('/', 					\Modules\Backend\RAMPManagement\Actions\Events\Index::class)			->name('index');
			Route::get('/create', 				\Modules\Backend\RAMPManagement\Actions\Events\Create::class)			->name('create');
			Route::post('/', 					\Modules\Backend\RAMPManagement\Actions\Events\Store::class)			->name('store');
			Route::get('/{event}/edit', 		\Modules\Backend\RAMPManagement\Actions\Events\Edit::class)				->name('edit');
			Route::put('/{event}', 				\Modules\Backend\RAMPManagement\Actions\Events\Update::class)			->name('update');
			Route::delete('/{event}', 			\Modules\Backend\RAMPManagement\Actions\Events\Destroy::class)			->name('destroy');

			Route::get('/{event}/dump', 		\Modules\Backend\RAMPManagement\Actions\EventDumps\Create::class)		->name('create_dump');
			Route::post('/{event}/dump', 		\Modules\Backend\RAMPManagement\Actions\EventDumps\Store::class)		->name('store_dump');

		});

	});

});