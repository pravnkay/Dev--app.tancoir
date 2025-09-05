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

	Route::prefix('moderation')
	->name('moderation.')
	->group(function () {

		Route::get('/', function() {
			return view('moderation::dashboard.index');
		})->name('index');
		
		Route::prefix('profile')
		->name('profile.')
		->group(function () {

			Route::get('/',										\Modules\Backend\Moderation\Actions\Profiles\Index::class)			->name('index');
			Route::get('edit/{profile}',						\Modules\Backend\Moderation\Actions\Profiles\Edit::class)			->name('edit');
			Route::post('update/{profile}',						\Modules\Backend\Moderation\Actions\Profiles\Update::class)			->name('update');

		});

	});

});