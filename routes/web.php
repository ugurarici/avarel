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

Route::get('/', function () {
    return redirect()->route('articles.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('feed', 'HomeController@feed')->name('feed');


Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('/', 'ArticleController@index')->name('index');
    
    Route::middleware('auth')->group(function(){
        Route::get('/new', 'ArticleController@create')->name('create');
        Route::post('/', 'ArticleController@store')->name('store');
        Route::get('/{article}/edit', 'ArticleController@edit')->name('edit')->middleware('can:update,article');
        Route::post('/{article}', 'ArticleController@update')->name('update')->middleware('can:update,article');
        Route::post('/{article}/comments', 'ArticleController@addComment')->name('addComment');
    });

    Route::get('/{article}', 'ArticleController@detail')->name('detail');
});

Route::get('tags/{tag}', 'ArticleController@tagArticles')->name('tag.articles');
Route::get('users/{user}/articles', 'ArticleController@userArticles')->name('user.articles');

Route::get('havadurumu', 'HomeController@showWeather');

Route::get('notification/{id}', function($id){
    $notification = request()->user()->notifications()->where('id', $id)->firstOrFail();
    $notification->markAsRead();
    return redirect($notification->data['action']);
})->name('notification.action')->middleware('auth');

Route::get('generatesitemap', function(){
    \App\Jobs\GenerateSitemap::dispatch();
    return redirect()->route('feed');
});

Route::post('profile', 'ProfileController@update')->name('profile.update')->middleware('auth');

Route::prefix('{user}')->group(function () {
    Route::get('/follow', 'ProfileController@follow')->name('follow')->middleware('auth');
    Route::get('/unfollow', 'ProfileController@unfollow')->name('unfollow')->middleware('auth');
    Route::get('/', 'ProfileController@profile')->name('profile');
});