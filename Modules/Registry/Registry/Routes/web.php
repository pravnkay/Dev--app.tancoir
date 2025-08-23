<?php

use Illuminate\Support\Facades\Route;
use Modules\Registry\Registry\Actions\Index;

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
	->prefix('registry')
	->name('registry.')
	->group(function () {

		Route::get('/', 					Index::class)			->name('index');

	});

});