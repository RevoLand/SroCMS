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

    Route::post('articleComment/{id}-{slug}', 'ArticleCommentController@store')->name('articles.store_comment')->middleware(['auth', 'throttle:5,1']);
});

Route::group(['prefix' => 'users'], function ()
{
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('users.login_form');
    Route::post('login', 'Auth\LoginController@login')->name('users.do_login');

    Route::get('logout', 'Auth\LoginController@logout')->name('users.do_logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('users.register_form');
    Route::post('register', 'Auth\RegisterController@register')->name('users.do_register');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
});

Route::group(['prefix' => 'users'], function ()
{
    Route::get('/', 'UserController@index')->name('users.current_user');

    Route::get('edit', 'UserController@edit')->name('users.edit_form');
    Route::post('edit', 'UserController@update')->name('users.update_settings');
    Route::post('updateEmail', 'UserController@updateEmail')->name('users.update_email');
    Route::post('updatePassword', 'UserController@updatePassword')->name('users.update_password');

    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
});
