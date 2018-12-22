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

Route::resource('/messages', 'MessagesController');

Route::resource('/feedback', 'FeedbacksController');
Route::resource('/proposals', 'ProposalController');
Route::resource('/projects', 'ProjectsController');
Route::resource('/notifications', 'NotificationsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//shows all user
Route::get('/profile', 'ProfileController@index');
//shows all moderators
Route::get('/profile/moderator', 'ProfileController@index2');
//show each user
Route::get('/profile/{id}', 'ProfileController@show');
//show each modeator
Route::get('/profile/moderator/{id}', 'ProfileController@show2');

Route::get('/adminEvent', 'AdminController@event');
Route::post('/adminEvent/store', 'AdminController@addevent');


Route::get('/moderator/create', 'ProfileController@create')->middleware('auth:admin');
Route::post('/moderator/store', 'ProfileController@store')->middleware('auth:admin');
//Route::get('/profile/{id}', 'ProfileController@show')->name('profile.show');
//Route::delete('/profile/destroy/{id}', 'ProfileController@destroy')->middleware('auth:admin');
//delete a user
Route::delete('{id}', 'ProfileController@destroy')->middleware('auth:admin');
//delete a moderator
Route::delete('/moderator/{id}', 'ProfileController@destroy2')->middleware('auth:admin');

Route::get('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('moderator')->group(function() {
    Route::get('/login', 'Auth\ModeratorLoginController@showLoginForm')->name('moderator.login');
    Route::post('/login', 'Auth\ModeratorLoginController@login')->name('moderator.login.submit');
    Route::get('/logout', 'Auth\ModeratorLoginController@logout')->name('moderator.logout');    
    Route::get('/', 'ModeratorController@index')->name('moderator.dashboard');
    
    Route::post('/password/email','Auth\ModeratorForgotPasswordController@sendResetLinkEmail')->name('moderator.password.email');
    Route::get('/password/reset','Auth\ModeratorForgotPasswordController@showLinkRequestForm')->name('moderator.password.request');
    Route::post('/password/reset','Auth\ModeratorResetPasswordController@reset')->name('moderator.password.update');
    Route::get('/password/reset/{token}','Auth\ModeratorResetPasswordController@showResetForm')->name('moderator.password.reset');
});

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');    
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    Route::post('/password/email','Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset','Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset','Auth\AdminResetPasswordController@reset')->name('admin.password.update');
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});