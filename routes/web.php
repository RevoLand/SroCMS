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

// Geçici
Theme::set('crusader');

Route::get('/', 'ArticleController@index')->name('articles');

Route::group(['prefix' => 'articles'], function()
{
    Route::get('/', 'ArticleController@index')->name('articles');

    Route::get('{id}-{slug}', 'ArticleController@show')->name('showArticle');
});
