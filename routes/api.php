<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('gettoken', function(Request $request){

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return ['token' => Auth::user()->api_token];
    }

    return response()->json([
        'message' => 'Geçerli bir kullanıcı bulunamadı.'
    ], 401);
});

Route::resource('articles', 'API\ArticleResourceController');
