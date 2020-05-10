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

use App\Item;
use App\MagicOpt;
use App\User;

Route::get('/', 'ArticleController@index')->name('home');

Route::group(['prefix' => 'articles'], function ()
{
    Route::get('/', 'ArticleController@index')->name('articles.show_articles');

    Route::get('categories/{category:slug}', 'ArticleCategoryController@show')->name('articles.get_category');
    Route::get('comments/{article:slug}', 'ArticleCommentController@show')->name('articles.get_comments');

    Route::get('{article:slug}', 'ArticleController@show')->name('articles.show_article');
    Route::post('{article:slug}', 'ArticleCommentController@store')->name('articles.store_comment');
});

// Dinamik sayfa işlemleri
// Middleware: dinamik olarak atanmaktadır.
Route::group(['prefix' => 'pages', 'as' => 'pages.'], function ()
{
    Route::get('{page:slug}', 'PageController@show')->name('show_page');
});

// Misafir işlemleri
// Not: İlgili işlemlerin middleware'ları kontrolcülerin içerisinde constructor olarak yer almaktadır.
// Middleware: guest
Route::group(['prefix' => 'users'], function ()
{
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('users.login_form');
    Route::post('login', 'Auth\LoginController@login')->name('users.do_login');

    Route::post('logout', 'Auth\LoginController@logout')->name('users.do_logout');

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

    Route::get('referrer', 'ReferralController@index')->name('users.referrals');
    Route::post('referrer/update', 'ReferralController@update')->name('users.set_referrer');

    Route::get('balance', 'UserController@balance')->name('users.balance');

    Route::get('orders', 'UserController@orders')->name('users.orders.index');
    Route::get('orders/{order}', 'UserController@showorder')->name('user.orders.show');

    Route::get('tickets', 'TicketController@index')->name('users.tickets.index');
    Route::get('tickets/create', 'TicketController@create')->name('users.tickets.create');
    Route::get('tickets/{ticket}', 'TicketController@show')->name('users.tickets.show');

    Route::post('tickets', 'TicketController@store')->name('users.tickets.store');
    Route::post('tickets/{ticket}', 'TicketMessageController@store')->name('users.tickets.messages.store');
});

Route::group(['prefix' => 'uniques', 'as' => 'uniques.'], function ()
{
    Route::get('', 'UniqueController@index')->name('index');
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

            Route::resource('comments', 'Admin\ArticleCommentController', ['as' => 'articles']);
            Route::patch('comments/{comment}/toggleVisibility', 'Admin\ArticleCommentController@toggleVisibility')->name('articles.comments.toggle_visibility');
            Route::patch('comments/{comment}/toggleApproved', 'Admin\ArticleCommentController@toggleApproved')->name('articles.comments.toggle_approved');
        });

        Route::resource('articles', 'Admin\ArticleController')->middleware('can:manage articles');
        Route::patch('articles/{article}/toggleVisibility', 'Admin\ArticleController@toggleVisibility')->name('articles.toggle_visibility');
        Route::patch('articles/{article}/toggleComments', 'Admin\ArticleController@toggleComments')->name('articles.toggle_comments');
    });

    Route::group(['middleware' => 'can:manage pages'], function ()
    {
        Route::resource('pages', 'Admin\PageController');
        Route::patch('pages/{page}/toggleEnabled', 'Admin\PageController@toggleEnabled')->name('pages.toggle_enabled');
    });

    Route::group(['middleware' => 'can:manage tickets'], function ()
    {
        Route::resource('tickets', 'Admin\TicketController');
        Route::patch('tickets/{ticket}/update_status', 'Admin\TicketController@update_status')->name('tickets.update_status');
        Route::patch('tickets/{ticket}/update_priority', 'Admin\TicketController@update_priority')->name('tickets.update_priority');
        Route::patch('tickets/{ticket}/update_assigned_user', 'Admin\TicketController@update_assigned_user')->name('tickets.update_assigned_user');
        Route::resource('ticketmessages', 'Admin\TicketMessageController');

        Route::post('tickets/{ticket}', 'Admin\TicketMessageController@store')->name('ticketmessages.store');
        // Route::patch('pages/{page}/toggleEnabled', 'Admin\PageController@toggleEnabled')->name('pages.toggle_enabled');
    });

    Route::group(['middleware' => 'can:manage votes'], function ()
    {
        Route::group(['prefix' => 'votes', 'as' => 'votes.'], function ()
        {
            Route::resource('providers/ips', 'Admin\VoteProviderIpController', ['as' => 'providers']);

            Route::resource('rewardgroups', 'Admin\VoteProviderRewardGroupController');
            Route::patch('rewardgroups/{rewardgroup}/toggleEnabled', 'Admin\VoteProviderRewardGroupController@toggleEnabled')->name('rewardgroups.toggle_enabled');

            Route::post('rewards/update', 'Admin\VoteProviderRewardController@update')->name('rewards.update');
            Route::post('rewards/destroy', 'Admin\VoteProviderRewardController@destroy')->name('rewards.destroy');

            Route::patch('rewards/{reward}/toggleEnabled', 'Admin\VoteProviderRewardController@toggleEnabled')->name('rewards.toggle_enabled');

            Route::resource('providers', 'Admin\VoteProviderController');
            Route::patch('providers/{provider}/toggleEnabled', 'Admin\VoteProviderController@toggleEnabled')->name('providers.toggle_enabled');
            Route::post('providers/{provider}/getCallbackUrl', 'Admin\VoteProviderController@getCallbackUrl')->name('providers.get_callback_url');
        });

        Route::resource('votes', 'Admin\VoteLogController');
        Route::patch('votes/{votelog}/reward', 'VoteController@rewardVote')->name('votes.reward');
        Route::patch('votes/{votelog}/toggle_active', 'Admin\VoteLogController@toggleActive')->name('votes.toggle_active');
    });

    Route::group(['middleware' => 'can:manage epins'], function ()
    {
        Route::resource('epins', 'Admin\EpinController');
        Route::patch('epins/{epin}/toggleEnabled', 'Admin\EpinController@toggleEnabled')->name('epins.toggle_enabled');
        Route::post('epins/items/update', 'Admin\EpinItemController@update')->name('epins.items.update');
        Route::post('epins/items/destroy', 'Admin\EpinItemController@destroy')->name('epins.items.destroy');
    });

    Route::group(['middleware' => 'can:manage itemmall', 'prefix' => 'itemmall', 'as' => 'itemmall.'], function ()
    {
        Route::get('', 'Admin\ItemMallController@index')->name('index');

        // Web Item Mall Categories
        Route::resource('categories', 'Admin\ItemMallCategoryController');
        Route::patch('categories/{category}/toggleEnabled', 'Admin\ItemMallCategoryController@toggleEnabled')->name('categories.toggle_enabled');

        // Web Item Mall Item Groups
        Route::resource('itemgroups', 'Admin\ItemMallItemGroupController');
        Route::patch('itemgroups/{itemgroup}/toggleEnabled', 'Admin\ItemMallItemGroupController@toggleEnabled')->name('itemgroups.toggle_enabled');

        Route::post('itemgroups/items/update', 'Admin\ItemMallItemController@update')->name('itemgroups.items.update');
        Route::post('itemgroups/items/destroy', 'Admin\ItemMallItemController@destroy')->name('itemgroups.items.destroy');
    });

    Route::group(['middleware' => 'can:manage itemmall orders'], function ()
    {
        Route::get('itemmall/orders/{order}', 'Admin\ItemMallOrderController@show')->name('itemmall.orders.show');
    });

    Route::resource('users', 'Admin\UserController');
    Route::group(['prefix' => 'ajax/users/{user}/', 'as' => 'ajax.users.'], function ()
    {
        Route::get('getCounts', 'Admin\UserController@getCounts')->name('get_counts');
        Route::get('getVoteInfo', 'Admin\UserController@getVoteInfo')->name('get_voteinfo');
        Route::get('getVoteInfoByRewards', 'Admin\UserController@getVoteInfoByRewards')->name('get_voteinfobyrewards');
        Route::get('getVoteInfoByProviders', 'Admin\UserController@getVoteInfoByProviders')->name('get_voteinfobyproviders');
    });
    Route::group(['prefix' => 'ajaxData', 'as' => 'ajax.'], function ()
    {
        Route::get('users/getUsername', 'Admin\UserController@getUsernames')->name('users.get_usernames');
    });

    Route::group(['prefix' => 'teleports', 'as' => 'teleports.', 'middleware' => 'can:manage teleports'], function ()
    {
        Route::get('', 'Admin\TeleportController@index')->name('index');
        Route::post('update', 'Admin\TeleportController@update')->name('update');
        Route::post('destroy', 'Admin\TeleportController@destroy')->name('destroy');

        Route::post('link/update', 'Admin\TeleLinkController@update')->name('link.update');
        Route::post('link/destroy', 'Admin\TeleLinkController@destroy')->name('link.destroy');

        Route::get('reverse-points', 'Admin\OptionalTeleportController@index')->name('reverse_points.index');
        Route::post('reverse-points/update', 'Admin\OptionalTeleportController@update')->name('reverse_points.update');
        Route::post('reverse-points/destroy', 'Admin\OptionalTeleportController@destroy')->name('reverse_points.destroy');
    });

    Route::group(['prefix' => 'characters', 'as' => 'characters.'], function ()
    {
        Route::post('getPosition', 'Admin\CharacterController@getPosition')->name('get_position');
    });
});

Route::match(['get', 'post'], 'item-test', function ()
{
    if ($_POST)
    {
        $optId = $_POST['optid'];
        $value = $_POST['value'] ?: MagicOpt::find($optId)->stats->maxValue;

        $magicParam = ($value << 32) | $optId;

        echo "<h4>{$magicParam}</h4><h5>[{$optId}] {$value}</h5>";

        Item::find(178880)->update([
            'MagParamNum' => 1,
            'MagParam1' => $magicParam,
        ]);
    } ?>

    <form method="post" action="">
        <input class="form-control" type="text" name="optid" placeholder="Magic Option ID">
        <input class="form-control" type="text" name="value" placeholder="Value">
        <button type="submit" class="btn btn-falcon-primary">Submit</button>
    </form>
<?php
});

Route::get('statistics', 'StatisticsController@index');

Route::get('random', function ()
{
    echo $randomString = Str::random(40);
});

Route::get('test', function ()
{
    // // User::where('StrUserID', 'ali')->first()->silk->increase(config('constants.silk.type.id.silk_point'), 100000, config('constants.silk.reason.inc.silk_point'), 'SroCMS Deneme');
    Auth::user()->balance->increase(config('constants.balance.type.balance'), 100, config('constants.balance.source.admin'));

    // $user->silk->decrease(config('constants.silk.type.id.silk_own'), 50, config('constants.silk.reason.dec.silk_own'), 'SroCMS Deneme');
    // $user->silk->decrease(config('constants.silk.type.id.silk_gift'), 50, config('constants.silk.reason.dec.silk_gift'), 'SroCMS Deneme');
    // $user->silk->decrease(config('constants.silk.type.id.silk_point'), 50, config('constants.silk.reason.dec.silk_point'), 'SroCMS Deneme');

    // $user->silk->increase(config('constants.silk.type.id.silk_own'), 100, config('constants.silk.reason.inc.silk_own'), 'SroCMS Deneme');
    // $user->silk->increase(config('constants.silk.type.id.silk_gift'), 100, config('constants.silk.reason.inc.silk_gift'), 'SroCMS Deneme');
    // $user->silk->increase(config('constants.silk.type.id.silk_point'), 100, config('constants.silk.reason.inc.silk_point'), 'SroCMS Deneme');

    echo 'ok';
});
