<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Moderation\Actions\Profiles\Index;
use Modules\Backend\Moderation\Actions\Profiles\Edit;
use Modules\Backend\Moderation\Actions\Profiles\Update;

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

	Route::middleware(['auth', 'verified', 'role:admin'])
	->prefix('moderation')
	->name('moderation.')
	->group(function () {

		Route::get('/', function() {
			return view('moderation::dashboard.index');
		})->name('index');
		
		Route::middleware(['auth', 'verified', 'role:admin'])
		->prefix('profile')
		->name('profile.')
		->group(function () {

			Route::get('/',										Index::class)			->name('index');
			Route::get('edit/{profile_type}/{profile_id}/',		Edit::class)			->name('edit');
			Route::post('update/{profile_type}/{profile_id}/',	Update::class)			->name('update');

		});

	});

});