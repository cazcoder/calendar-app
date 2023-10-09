<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'admin' ], function(){

    //Edit Profile and logout
    Route::post('profile', 'App\Http\Controllers\UserController@updateProfile');
    Route::get('profile', 'App\Http\Controllers\UserController@retrieveProfile');
    Route::get('logout', 'App\Http\Controllers\UserController@logout');

    //Calendar

    //fetch calendar data --> monthColors (legend) and dayColors
    Route::post('countries/index', 'App\Http\Controllers\CountriesController@index'); 

    //fetch all countries (used when assigning) as well as saved countries
    Route::post('countries/get_assigned', 'App\Http\Controllers\CountriesController@getAssignedCountries');
    
    //save assigned countries
    Route::post('countries/save_assigned', 'App\Http\Controllers\CountriesController@saveAssignedCountries'); 
    
    //Dashboard
    Route::get('dashboard', 'App\Http\Controllers\DashboardController@dashboard');
    
});
//Route::get('countries', 'App\Http\Controllers\CountriesController@getCountries');
Route::get('/', 'App\Http\Controllers\AdminController@index');
Route::post('login', 'App\Http\Controllers\UserController@login');
Route::post('register', 'App\Http\Controllers\UserController@register');
Route::any('{slug}', 'App\Http\Controllers\AdminController@index');
