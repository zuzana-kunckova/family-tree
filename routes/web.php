<?php

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'people', 'as' => 'people.'], function () {
    Route::get('/', 'PeopleController@index')->name('index');
    Route::post('/', 'PeopleController@store')->name('store');
    Route::get('{person}', 'PeopleController@show')->name('show');
    Route::get('create', 'PeopleController@create')->name('create');
});

Route::get('/graph', function(){
    return view('graph');
});