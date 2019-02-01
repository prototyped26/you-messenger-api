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
Route::middleware(['cors'])->prefix('messages')->group(function () {
    Route::post('/save-one/{telephone}', 'Api\MessageController@storeOne');
    Route::get('/not-read/{telephone}', 'Api\MessageController@getNotRead');
    Route::post('/save-notification/{telephone}', 'Api\MessageController@storeActualite');
    Route::get('/read-notification/{telephone}', 'Api\MessageController@getNotReadActualite');
    Route::get('/complete-notifications/{id}', 'Api\MessageController@updateActualites');
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
///
///

////////////// GESTION DES CONTACTS DES UTILISATEURS ///////////////

Route::middleware(['cors','auth:api'])->prefix('contacts')->group(function () {
    Route::get('/list', 'Api\ContactController@list');
    Route::post('/one', 'Api\ContactController@storeOne');
    Route::post('/many', 'Api\ContactController@storeMany');
});

/// //////////////////   FIN     ////////////////////////////


////////////// GESTION DES NOTIFICATIONS ///////////////

Route::middleware(['cors'])->prefix('notifications')->group(function () {
    Route::get('/get/{telephone}', 'Api\NotificationController@getNotif');
    Route::post('/save/{telephone}', 'Api\NotificationController@store');
});

/// //////////////////   FIN     ////////////////////////////

/////////// GESTION DES GROUPES ///////////////
Route::middleware(['cors','auth:api'])->prefix('groupes')->group(function () {
    Route::get('/show/{id}', 'Api\GroupeController@getGroupe');
    Route::post('/create', 'Api\GroupeController@create');
    Route::post('/update/{id}', 'Api\GroupeController@updateGroupe');
    Route::post('/admin/add', 'Api\GroupeController@addAdminGroup');
    Route::post('/admin/remove', 'Api\GroupeController@removeAdminGroup');
    Route::post('/member/add', 'Api\GroupeController@addMemberGroup');
    Route::post('/member/update', 'Api\GroupeController@updateMemberGroup');
    Route::post('/member/remove', 'Api\GroupeController@removeMemberGroup');
});
/////////////////////////////////////////////



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
