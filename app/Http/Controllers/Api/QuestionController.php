<?php

namespace App\Http\Controllers\Api;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        Log::info($request);
        $question = Question::updateOrCreate(
            ['id'=> $request->input('questionId')],
            [
                'survey_id' => $request->input('surveyId'),
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
}
