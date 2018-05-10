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

Route::get("/", "StaticPagesController@home")->name('home');

Route::get('/help', 'StaticPagesController@help')->name('help');

Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UserController@create')->name('signup');
Route::get('/signup/confirm/{token}', 'UserController@confirmEmail')->name('confirm_email');

Route::resource('user', "UserController");
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);    //  post处理创建微博的请求 DELETE处理删除请求

Route::get('login', 'SessionsController@create')->name('login');    //  显示登录页
Route::post('login', 'SessionsController@store')->name('login');   //  创建新回话（登录）
Route::delete('logout', "SessionsController@destroy")->name('logout'); //  销毁登录

//  密码重置

Route::get('password/reset', "Auth\ForgotPasswordController@showLinkRequestForm")->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');