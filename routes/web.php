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

// Theme::set('crusader');

Route::get('/', 'ArticleController@index')->name('home');

Route::group(['prefix' => 'articles'], function()
{
    Route::get('/', 'ArticleController@index')->name('articles');

    Route::get('{id}-{slug}', 'ArticleController@show')->name('showArticle');

    Route::post('comment/{id}-{slug}', 'ArticleCommentController@store')->name('storeComment');
});

Route::group(['prefix' => 'user'], function()
{
    Route::get('/login', 'LoginController@show')->name('loginPage');
    Route::middleware('throttle:60,1')->post('/login', 'LoginController@authenticate')->name('login');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::get('/register', 'RegisterController@show')->name('registerPage');
    Route::middleware('throttle:60,1')->post('/register', 'RegisterController@register')->name('register');
});

Route::group(['middleware' => 'user', 'prefix' => 'user'], function()
{
    Route::get('/', 'UserController@index')->name('user');
});
