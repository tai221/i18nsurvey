<?php

namespace App\Http\Controllers\Api;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    public function create(Request $request)
    {
        $survey = Survey::updateOrCreate(
            ['id'=> $request->input('surveyId')],
            [
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'dear' => $request->input('dear'),
            'greeting' => $request->input('greeting'),]
        );
        return response()->json([
            'code' => 201,
            'message' => 'Create success',
            'survey_id' => $survey->id,
        ], 200);
    }

    public function fetch(Request $request)
    {
        $survey = Survey::find($request['id']);
        return response()->json([
            'code' => 200,
            'survey' => $survey,
        ], 200);
    }
}
