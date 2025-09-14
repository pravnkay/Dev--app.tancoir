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

Route::middleware('guest')
->prefix('pubform')
->name('pubform.')
->group(function () {

	Route::middleware(['guest'])
	->prefix('ramp')
	->name('ramp.')
	->group(function () {
		
		Route::get('/',    \Modules\Backend\PubForm\Actions\RAMP\Index::class)    ->name('index');

	});



});