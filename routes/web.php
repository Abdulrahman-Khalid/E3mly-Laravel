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

Route::get('/', 'PagesController@index');
Route::resource('/posts', 'PostsController');
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('moderator')->group(function() {
    Route::get('/login', 'Auth\ModeratorLoginController@showLoginForm')->name('moderator.login');
    Route::post('/login', 'Auth\ModeratorLoginController@login')->name('moderator.login.submit');
    Route::get('/logout', 'Auth\ModeratorLoginController@logout')->name('moderator.logout');    
    Route::get('/', 'ModeratorController@index')->name('moderator.dashboard'); //lazm tb2a f el a5er    
});

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');    
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');    
    Route::get('/', 'AdminController@index')->name('admin.dashboard'); //lazm tb2a f el a5er    
});
