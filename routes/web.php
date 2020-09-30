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

// User Profile Routes
Route::get('/profile', 'ProfileController@userProfile');
Route::get('/getProfileData', 'ProfileController@getProfileData');
Route::get('/getProfileEditDetails', 'ProfileController@getProfileEditDetails');
Route::post('/updateProfileInfo', 'ProfileController@updateProfileInfo');

// Password Update Routes
Route::get('/update-password', 'ProfileController@updatePassword');
Route::post('/checkCurrentPass', 'ProfileController@checkCurrentPass');
Route::post('/updatePass', 'ProfileController@updatePass');

// Supplier Routes
Route::get('/suppliers', 'SupplierController@index');
Route::get('/getSuppliers', 'SupplierController@getSuppliers');
Route::post('/addSupplier', 'SupplierController@addSupplier');
Route::get('/getSupplierDetails/{id}', 'SupplierController@getSupplierDetails');
Route::post('/updateSupplierDetails', 'SupplierController@updateSupplierDetails');
Route::get('/delete-Supplier/{id}', 'SupplierController@deleteSupplier');

// Customer Routes
Route::get('/customers', 'CustomerController@index');
Route::get('/getCustomers', 'CustomerController@getCustomers');
Route::get('/delete-Customer/{id}', 'CustomerController@deleteCustomer');

Auth::routes(); 

Route::get('/home', 'HomeController@index')->name('home');
