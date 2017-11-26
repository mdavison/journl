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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/journals', 'JournalController@index');
Route::post('/journals', 'JournalController@store');
Route::get('/journals/create', 'JournalController@create');
Route::get('/journals/{journal}', 'JournalController@show');
Route::delete('/journals/{journal}', 'JournalController@destroy');

Route::post('/entries', 'EntryController@store');
Route::delete('/entries/{entry}', 'EntryController@destroy');
