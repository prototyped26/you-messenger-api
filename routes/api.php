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

Route::get('auth-login', function (Request $request) {
    return response()->json(['error' => 'Authorization'], 401);
})->name('auth-login');

Route::middleware(['cors','auth:api'])->prefix('information')->group(function () {
    Route::post('/file/up', 'Api\UserFileController@saveFile');
});

//gestion des messages
Route::middleware(['cors','auth:api'])->prefix('messages')->group(function () {
    Route::post('/send', 'Api\MessageController@store');
});
/// les méthodes utilisateurs
Route::middleware(['cors'])->prefix('account')->group(function () {
    Route::post('/login', 'Api\UserController@login');
    Route::post('/register', 'Api\UserController@register');
}); 

Route::middleware(['cors','auth:api'])->prefix('users')->group(function () {
    Route::get('/other', 'Api\UserController@otherUsers');
    Route::get('/me', 'Api\UserController@me');
    Route::post('/update', 'Api\UserController@update');
});

//// FIN ////////////////////////////

Route::middleware(['cors', 'auth:api'])->group(function () {
    Route::get('logout', 'Api\UserController@logout');
});


Route::middleware(['cors'])->prefix('langues')->group(function () {
    Route::get('/', 'Api\LangueController@list');
    Route::get('/{id}', 'Api\LangueController@detail');

    Route::post('/', 'Api\LangueController@store');
    Route::post('/{id}', 'Api\LangueController@update');

    Route::delete('/{id}', 'Api\LangueController@delete');
});
