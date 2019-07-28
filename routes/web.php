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


Route::get('articles', 'ArticleController@index')->name('articles.index');
Route::get('articles/new', 'ArticleController@create')->name('articles.create')->middleware('auth', 'checkage:18');
Route::post('articles', 'ArticleController@store')->name('articles.store')->middleware('auth');
Route::get('articles/{article}', 'ArticleController@detail')->name('articles.detail');
Route::get('articles/{article}/edit', 'ArticleController@edit')->name('articles.edit')->middleware('auth');
Route::post('articles/{article}', 'ArticleController@update')->name('articles.update')->middleware('auth');
Route::post('articles/{article}/comments', 'ArticleController@addComment')->name('articles.addComment')->middleware('auth');
Route::get('tags/{tag}', 'ArticleController@tagArticles')->name('tag.articles');
Route::get('users/{user}/articles', 'ArticleController@userArticles')->name('user.articles');

Route::get('havadurumu', 'HomeController@showWeather');

Route::post('profile', 'ProfileController@update')->name('profile.update')->middleware('auth');
Route::get('{user}/follow', 'ProfileController@follow')->name('follow')->middleware('auth');
Route::get('{user}/unfollow', 'ProfileController@unfollow')->name('unfollow')->middleware('auth');
Route::get('{user}', 'ProfileController@profile')->name('profile');