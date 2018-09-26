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
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup','UsersController@create')->name('signup');
Route::resource('users','UsersController');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
/*Laravel 将密码重设功能相关的逻辑代码都放在了 ForgotPasswordController 和 ResetPasswordController 中，因此我们接下来需要将重设密码相关的路由指定到该控制器上。*/

/*显示重置密码的邮箱发送页面*/
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
/*邮箱发送重设链接*/
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
/*密码更新页面*/
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
/*执行密码更新操作*/
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/*定义用户关注者列表和粉丝列表的路由，用于对接下来的关注人列表和粉丝列表进行显示。*/
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
/*针对前面开发的「关注用户」和「取消用户」的功能，加入路由定义。*/
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');