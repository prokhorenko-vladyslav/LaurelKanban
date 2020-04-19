<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//middleware('auth:api')->
Route::prefix('kanban')->namespace('\Laurel\Kanban\Http\Controllers')->group(function () {
    Route::match(['PUT', 'PATCH'], 'desk/{desk}/favorite', [
            'uses' => 'DeskController@favorite',
            'as' => 'desk.favorite'
        ]);

    Route::match(['PUT', 'PATCH'], 'desk/{desk}/unfavorite', [
            'uses' => 'DeskController@unfavorite',
            'as' => 'desk.unfavorite'
        ]);

    Route::match(['PUT', 'PATCH'], 'desk/{desk}/private', [
            'uses' => 'DeskController@private',
            'as' => 'desk.private'
        ]);

    Route::match(['PUT', 'PATCH'], 'desk/{desk}/public', [
            'uses' => 'DeskController@public',
            'as' => 'desk.public'
        ]);

    Route::apiResource('desk', 'DeskController');
});
