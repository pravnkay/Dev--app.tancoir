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
->prefix('rampmanagement')
->name('rampmanagement.')
->group(function () {

	Route::prefix('dashboard')
	->name('dashboard.')
	->group(function () {

		Route::get('/', 			\Modules\Backend\RAMPManegement\Actions\Dashboard\Index::class)			->name('index');

	});

	Route::prefix('verticals')
	->name('verticals.')
	->group(function () {

		Route::get('/', 			\Modules\Backend\RAMPManegement\Actions\Verticals\Index::class)			->name('index');

	});

});