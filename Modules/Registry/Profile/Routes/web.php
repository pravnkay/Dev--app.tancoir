<?php

use Illuminate\Support\Facades\Route;
use Modules\Registry\Profile\Actions\Profiles\Index;
use Modules\Registry\Profile\Actions\Profiles\Create;
use Modules\Registry\Profile\Actions\Profiles\Destroy;
use Modules\Registry\Profile\Actions\Profiles\Store;
use Modules\Registry\Profile\Actions\Profiles\Activate;
use Modules\Registry\Profile\Actions\Profiles\Edit;
use Modules\Registry\Profile\Actions\Profiles\Show;
use Modules\Registry\Profile\Actions\Profiles\Update;

use Modules\Registry\Profile\Actions\Profiles\Update\Enterprise;
use Modules\Registry\Profile\Actions\Profiles\Update\Cluster;
use Modules\Registry\Profile\Actions\Profiles\Update\Society;
use Modules\Registry\Profile\Actions\Profiles\Update\Association;

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

		Route::get('/', 												Index::class)			->name('index');
		Route::get('/create', 											Create::class)			->name('create');
		Route::post('/',												Store::class)			->name('store');
		Route::get('/{profile_type}/{profile_id}/',						Show::class)			->name('show');
		Route::get('/{profile_type}/{profile_id}/edit',					Edit::class)			->name('edit');
		Route::put('/{profile_type}/{profile_id}/edit',					Update::class)			->name('update');
		Route::put('activate/{profile_type}/{profile_id}',				Activate::class)		->name('activate');
		Route::delete('/{profile_type}/{profile_id}',					Destroy::class)			->name('destroy');
		
	});

});