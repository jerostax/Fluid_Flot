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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'FrontController@index')->name('home');
Route::post('/newsletter', 'FrontController@newsLetter');

Route::get('/events', 'FrontController@showEvents')->name('events');
Route::get('/shop', 'FrontController@showShop')->name('shop');
Route::get('/partners', 'FrontController@showPartners')->name('partners');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');