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
Route::get('/', 'ArticleController@index')->name('home');

Route::group(['prefix' => 'articles'], function ()
{
    Route::get('/', 'ArticleController@index')->name('articles.show_articles');

    Route::get('{id}-{slug}', 'ArticleController@show')->name('articles.show_article');

    Route::post('articleComment/{id}-{slug}', 'ArticleCommentController@store')->name('articles.store_comment');
});

Route::group(['prefix' => 'users', 'middleware' => 'guests'], function ()
{
    Route::get('login', 'AuthController@show')->name('users.login_form');
    Route::middleware('throttle:60,1')->post('login', 'AuthController@authenticate')->name('users.do_login');

    Route::get('register', 'UserController@create')->name('users.register_form');
    Route::middleware('throttle:60,1')->post('register', 'UserController@store')->name('users.do_register');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['prefix' => 'users', 'middleware' => 'users'], function ()
{
    Route::get('/', 'UserController@index')->name('users.current_user');

    Route::get('edit', 'UserController@edit')->name('users.edit_form');
    Route::post('edit', 'UserController@update')->name('users.update_settings');
    Route::post('updateEmail', 'UserController@updateEmail')->name('users.update_email');
    Route::post('updatePassword', 'UserController@updatePassword')->name('users.update_password');

    Route::get('logout', 'AuthController@logout')->name('users.do_logout');
});
