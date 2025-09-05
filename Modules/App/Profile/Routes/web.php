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

	
	Route::middleware(['auth', 'verified', 'role:user'])
	->prefix('profile')
	->name('profile.')
	->group(function () {

		Route::get('/', 												\Modules\App\Profile\Actions\Profiles\Index::class)			->name('index');
		Route::get('/create', 											\Modules\App\Profile\Actions\Profiles\Create::class)		->name('create');
		Route::post('/',												\Modules\App\Profile\Actions\Profiles\Store::class)			->name('store');
		Route::get('/{profile}',										\Modules\App\Profile\Actions\Profiles\Show::class)			->name('show');
		Route::get('/{profile}/edit',									\Modules\App\Profile\Actions\Profiles\Edit::class)			->name('edit');
		Route::put('/{profile}/edit',									\Modules\App\Profile\Actions\Profiles\Update::class)		->name('update');
		Route::put('activate/{profile}',								\Modules\App\Profile\Actions\Profiles\Activate::class)		->name('activate');
		Route::delete('/{profile}',										\Modules\App\Profile\Actions\Profiles\Destroy::class)		->name('destroy');
		
	});

});