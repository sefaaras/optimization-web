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

use App\Http\Controllers\PanelController;

Auth::routes();

Route::get('/', 'HomeController@home')->name('home');

Route::get('/panel', 'PanelController@home')->name('panel');

Route::get('/panel/user-management', 'PanelController@users')->name('user-management');
Route::get('/panel/user-list', 'PanelController@userList');
Route::post('/panel/add-user', 'PanelController@addUser');
Route::post('/panel/update-user', 'PanelController@updateUser');
Route::post('/panel/delete-user', 'PanelController@deleteUser');

Route::get('/panel/algorithm-management', 'PanelController@algorithms')->name('algorithm-management');
Route::get('/panel/algorithm-list', 'PanelController@algorithmList');
Route::post('/panel/add-algorithm', 'PanelController@addAlgorithm');
Route::post('/panel/update-algorithm', 'PanelController@updateAlgorithm');
Route::post('/panel/delete-algorithm', 'PanelController@deleteAlgorithm');