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

Route::get('room', 'RoomController@index');
Route::get('room/{id}', 'RoomController@room');

Route::post('room/{id}', 'RoomController@create');

Route::get('test', 'RoomController@test');

Route::get('leave', 'RoomController@leave');

// User behavior
Route::get('/register', 'UserController@register');
Route::post('/register', 'UserController@create');
Route::get('/login', 'UserController@login');
Route::post('/login', 'UserController@logging');