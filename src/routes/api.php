<?php

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
Route::prefix('kanban')->namespace('\Laurel\Kanban\App\Http\Controllers')->group(function () {
    Route::post('/auth/register', 'AuthController@register');
    Route::post('/auth/login', 'AuthController@login');

    Route::middleware('auth:api')->group(function () {
        Route::get('/auth/logout', 'AuthController@logout');
        Route::get('/auth/init', 'AuthController@init');

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

        Route::match(['PUT', 'PATCH'], 'desk/{desk}/collumn/reorder', [
                'uses' => 'CollumnController@reorder',
                'as' => 'collumn.reorder'
            ]);
        Route::apiResource('desk.collumn', 'CollumnController');

        Route::match(['PUT', 'PATCH'], 'desk/{desk}/collumn/{collumn}/card/reorder', [
                'uses' => 'CardController@reorder',
                'as' => 'card.reorder'
            ]);

        Route::apiResource('desk.card', 'CardController');
    });
});
