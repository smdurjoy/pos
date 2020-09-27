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

Route::get('/', 'HomeController@index');

// User Routes
Route::get('/users', 'UserController@users');
Route::get('/getUserData', 'UserController@getUserData');
Route::post('/addUser', 'UserController@addUser');
Route::get('/delete-User/{id}', 'UserController@deleteUser');
Route::get('/getUserEditDetails/{id}', 'UserController@getUserEditDetails');
Route::post('/updateUserDetails', 'UserController@updateUserDetails');

Auth::routes(); 

Route::get('/home', 'HomeController@index')->name('home');
