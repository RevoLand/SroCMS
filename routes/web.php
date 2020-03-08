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
use App\MagicOpt;

Route::get('/', 'ArticleController@index')->name('home');

Route::group(['prefix' => 'articles'], function ()
{
    Route::get('/', 'ArticleController@index')->name('articles.show_articles');

    Route::get('categories/{category}', 'ArticleCategoryController@show')->name('articles.get_category');
    Route::get('comments/{article}', 'ArticleCommentController@show')->name('articles.get_comments');

    Route::get('{article}', 'ArticleController@show')->name('articles.show_article');
    Route::post('{article}', 'ArticleCommentController@store')->name('articles.store_comment');
});

// Dinamik sayfa işlemleri
// Middleware: dinamik olarak atanmaktadır.
Route::group(['prefix' => 'pages', 'as' => 'pages.'], function ()
{
    Route::get('{page}', 'PageController@show')->name('show_page');
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

Route::group(['prefix' => 'votes', 'as' => 'votes.'], function ()
{
    // $this->middleware('auth')->except('callback');
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

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin', 'can:view admin']], function ()
{
    Route::get('', 'Admin\DashboardController@index')->name('dashboard.index');

    Route::group(['middleware' => 'can:manage articles'], function ()
    {
        Route::group(['prefix' => 'articles'], function ()
        {
            Route::resource('categories', 'Admin\ArticleCategoryController', ['as' => 'articles']);
            Route::patch('categories/{category}/toggleEnabled', 'Admin\ArticleCategoryController@toggleEnabled')->name('articles.categories.toggle_enabled');

            // comments/{comment}
            Route::resource('comments', 'Admin\ArticleCommentController', ['as' => 'articles']);
            Route::delete('comments/{comment}/destroyAjax', 'Admin\ArticleCommentController@destroyAjax')->name('articles.comments.destroy_ajax');
            Route::patch('comments/{comment}/toggleVisibility', 'Admin\ArticleCommentController@toggleVisibility')->name('articles.comments.toggle_visibility');
            Route::patch('comments/{comment}/toggleApproved', 'Admin\ArticleCommentController@toggleApproved')->name('articles.comments.toggle_approved');
        });

        Route::resource('articles', 'Admin\ArticleController')->middleware('can:manage articles');
        Route::patch('articles/{article}/toggleVisibility', 'Admin\ArticleController@toggleVisibility')->name('articles.toggle_visibility');
        Route::patch('articles/{article}/toggleComments', 'Admin\ArticleController@toggleComments')->name('articles.toggle_comments');
    });

    Route::resource('pages', 'Admin\PageController');
    Route::patch('pages/{page}/toggleEnabled', 'Admin\PageController@toggleEnabled')->name('pages.toggle_enabled');
    Route::resource('users', 'Admin\UserController');
});

Route::match(['get', 'post'], 'item-test', function ()
{
    if ($_POST)
    {
        $optId = $_POST['optid'];
        $value = $_POST['value'] ?: MagicOpt::find($optId)->stats->maxValue;

        $magicParam = ($value << 32) | $optId;

        echo "<h4>{$magicParam}</h4><h5>[{$optId}] {$value}</h5>";

        // Item::find(179384)->update([
        //     'MagParam1' => $magicParam,
        // ]);
    } ?>

    <form method="post" action="">
        <input class="form-control" type="text" name="optid" placeholder="Magic Option ID">
        <input class="form-control" type="text" name="value" placeholder="Value">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php
});

Route::get('test', function ()
{
    // increase($type, $balance, $source, $comment = '', $source_user_id = '')
    Auth::user()->balance->increase(config('constants.balance.type.balance'), 100, config('constants.balance.source.admin'));

    // $user->silk->decrease(config('constants.silk.type.id.silk_own'), 50, config('constants.silk.reason.dec.silk_own'), 'SroCMS Deneme');
    // $user->silk->decrease(config('constants.silk.type.id.silk_gift'), 50, config('constants.silk.reason.dec.silk_gift'), 'SroCMS Deneme');
    // $user->silk->decrease(config('constants.silk.type.id.silk_point'), 50, config('constants.silk.reason.dec.silk_point'), 'SroCMS Deneme');

    // $user->silk->increase(config('constants.silk.type.id.silk_own'), 100, config('constants.silk.reason.inc.silk_own'), 'SroCMS Deneme');
    // $user->silk->increase(config('constants.silk.type.id.silk_gift'), 100, config('constants.silk.reason.inc.silk_gift'), 'SroCMS Deneme');
    // $user->silk->increase(config('constants.silk.type.id.silk_point'), 100, config('constants.silk.reason.inc.silk_point'), 'SroCMS Deneme');

    echo 'ok';
});
