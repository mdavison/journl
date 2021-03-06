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
})->middleware('guest');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/journals', 'JournalController@index');
Route::post('/journals', 'JournalController@store');
Route::get('/journals/create', 'JournalController@create');
Route::get('/journals/{journal}', 'JournalController@show');
Route::get('/journals/{journal}/edit', 'JournalController@edit');
Route::patch('/journals/{journal}', 'JournalController@update');
Route::delete('/journals/{journal}', 'JournalController@destroy');

Route::post('/entries', 'EntryController@store');
Route::patch('/entries/{entry}', 'EntryController@update');
Route::delete('/entries/{entry}', 'EntryController@destroy');

Route::get('/search', 'SearchController@show');
