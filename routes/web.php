<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

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

Route::get('/', 'CountryController@show');

Route::get('/changeCountry/{name}', 'CountryController@changeCountryAPI');

Route::get('/test', 'CountryController@updateAll');

Route::get('/test2', function(){
    return view('main');
});