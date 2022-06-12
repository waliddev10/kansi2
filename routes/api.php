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

Route::get('/upcoming-agenda', 'UpcomingAgendaController@get_api');
Route::post('/agenda/{slug}', 'AgendaController@get_api_detail');

// get data for ajax

Route::prefix('data')->group(
    function () {
        Route::get('/workunits', 'ApiController@get_workunits')->name('api_workunits');
        Route::get('/positions', 'ApiController@get_positions')->name('api_positions');
        Route::get('/status-agendas', 'ApiController@get_status_agendas')->name('api_status_agendas');
    }
);
