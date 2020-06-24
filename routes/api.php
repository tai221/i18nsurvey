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
    Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
    Route::middleware('auth:api')->post('/getUserInfo', 'AuthController@getUserInfo');
});
Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::post('email/create', 'Api\ListParticipant@create');
    Route::post('email/get', 'Api\ListParticipant@get');
    Route::post('email/delete', 'Api\ListParticipant@delete');
    Route::post('email/lock', 'Api\ListParticipant@lock');
    Route::post('email/unlock', 'Api\ListParticipant@unlock');
    Route::post('account/create', 'Api\AccountController@create');
    Route::post('account/get', 'Api\AccountController@get');
    Route::post('account/delete', 'Api\AccountController@delete');
    Route::post('account/lock', 'Api\AccountController@lock');
    Route::post('account/unlock', 'Api\AccountController@unlock');
    Route::post('survey/create', 'Api\SurveyController@create');
    Route::get('survey/fetch/{id}', 'Api\SurveyController@fetch');
    Route::get('survey/countPage/{id}', 'Api\SurveyController@countPage');
    Route::get('survey/getListSurvey', 'Api\SurveyController@getListSurvey');
    Route::post('survey/deleteSurvey', 'Api\SurveyController@deleteSurvey');
    Route::post('survey/changeStateActive', 'Api\SurveyController@changeStateActive');
    Route::post('survey/submit', 'Api\SurveyController@submit');
    Route::post('survey/shareSurvey', 'Api\SurveyController@shareSurvey');
    Route::post('survey/analytic', 'Api\SurveyController@analytic');
    Route::get('survey/getAllResponse/{surveyId}', 'Api\SurveyController@getAllResponse');
    Route::post('question/create', 'Api\QuestionController@create');
    Route::post('question/getListQuestions', 'Api\QuestionController@fetchListQuestions');
    Route::post('question/getAllQuestions', 'Api\QuestionController@fetchAllQuestions');
    Route::post('question/getQuestion', 'Api\QuestionController@fetchQuestion');
    Route::post('question/deleteQuestion', 'Api\QuestionController@deleteQuestion');
});
