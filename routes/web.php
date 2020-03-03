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

/*
TODO:
Menüler controller değil de model içerisinden getByName gibi çağrılabilir/çağrılmalı?
Örnek:
use Harimayco\Menu\Facades\Menu;
$menuList = Menu::getByName('Admin');
*/

use App\Item;

Route::get('/', 'ArticleController@index')->name('home');

Route::group(['prefix' => 'articles'], function ()
{
    Route::get('/', 'ArticleController@index')->name('articles.show_articles');

    Route::get('{id}-{slug}', 'ArticleController@show')->name('articles.show_article');
    Route::post('{id}-{slug}', 'ArticleCommentController@store')->name('articles.store_comment');

    Route::get('categories/{slug}', 'ArticleCategoryController@show')->name('articles.get_category');
    Route::get('comments/{article}', 'ArticleCommentController@show')->name('articles.get_comments');
});

// Dinamik sayfa işlemleri
// Middleware: dinamik olarak atanmaktadır.
Route::group(['prefix' => 'pages', 'as' => 'pages.'], function ()
{
    Route::get('/', 'PageController@index')->name('show_pages');
    Route::get('{slug}', 'PageController@show')->name('show_page');
});

// Misafir işlemleri
// Not: İlgili işlemlerin middleware'ları kontrolcülerin içerisinde constructor olarak yer almaktadır.
// Middleware: guest
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

// Üye işlemleri.
// Not: İlgili işlemlerin middleware'ları kontrolcülerin içerisinde constructor olarak yer almaktadır.
// Middleware: auth
Route::group(['prefix' => 'users'], function ()
{
    Route::get('/', 'UserController@index')->name('users.current_user');
    Route::get('show/{user}', 'UserController@show')->name('users.show_user');

    Route::get('edit', 'UserController@edit')->name('users.edit_form');
    Route::post('edit', 'UserController@update')->name('users.update_settings');
    Route::post('updateEmail', 'UserController@updateEmail')->name('users.update_email');
    Route::post('updatePassword', 'UserController@updatePassword')->name('users.update_password');

    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::post('referrer/update', 'UserController@setReferrer')->name('users.set_referrer');

    Route::get('balance', 'UserController@balance')->name('users.balance');
});

Route::group(['prefix' => 'characters'], function ()
{
    Route::get('/', 'CharacterController@index')->name('users.characters.index');
    Route::get('{character}', 'CharacterController@show')->name('users.characters.show');
});

Route::group(['prefix' => 'guilds'], function ()
{
    Route::get('{guild}', 'GuildController@show')->name('users.guilds.show');
});

// Route::group(['prefix' => 'items', 'as' => 'items.'], function ()
// {
//     Route::get('{item}', 'ItemController@show')->name('show_item');
// });

// $this->middleware('auth')->except('callback');
Route::group(['prefix' => 'votes', 'as' => 'votes.'], function ()
{
    Route::get('/', 'VoteController@index')->name('show_votes');
    Route::post('{voteProvider}/vote', 'VoteController@vote')->name('do_vote');
});

Route::group(['prefix' => 'itemmall', 'as' => 'itemmall.', 'middleware' => 'auth'], function ()
{
    Route::get('/', 'ItemMallController@index')->name('index');

    Route::group(['prefix' => 'cart', 'as' => 'cart.'], function ()
    {
        Route::get('/', 'CartController@index')->name('index');
        Route::post('add/{itemgroup}', 'CartController@additem')->name('add');
        Route::post('checkout', 'CartController@checkout')->name('checkout');
        Route::patch('update', 'CartController@update')->name('update');
        Route::delete('delete/{itemgroup}', 'CartController@delete')->name('delete');
    });
});

Route::group(['prefix' => 'epin', 'as' => 'epin.', 'middleware' => 'auth'], function ()
{
    Route::get('', 'EpinController@index')->name('index');
    Route::post('use', 'EpinController@use')->name('use');
});
