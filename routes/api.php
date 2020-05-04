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
Route::group([ 'namespace' => 'Api\Auth'], function () {
    Route::post('/register', 'AuthController@signUp');
    Route::post('/login', 'AuthController@login');
});
Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::post('email/create', 'Api\ListParticipant@create');
    Route::post('email/get', 'Api\ListParticipant@get');
    Route::post('survey/create', 'Api\SurveyController@create');
    Route::get('survey/fetch/{id}', 'Api\SurveyController@fetch');
});
