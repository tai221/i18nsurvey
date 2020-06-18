<?php

namespace App\Http\Controllers\Api;

use App\Question;
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
            'greeting' => $request->input('greeting'),
            'thanks' => $request->input('thanks'),
            'ref_url' => $request->input('ref_url'),
            ]
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
        Log::info($survey);
        return response()->json([
            'code' => 200,
            'survey' => $survey,
        ], 200);
    }

    public function countPage(Request $request)
    {
        $surveyId = $request['id'];
        $countPage = Question::select('page')->where('survey_id', $surveyId)->orderBy('page','desc')->limit(1)->get();
        Log::info($surveyId);
        return response()->json([
            'code' => 200,
            'countPage' => $countPage,
        ], 200);
    }

    public function getListSurvey(Request $request)
    {
        $userId = Auth::id();
        Log::info($userId);
        $listSurvey = Survey::all()->where('user_id', $userId)->toArray();
        Log::info($listSurvey);
        if(count($listSurvey) > 0) {
            return response()->json([
                'listSurvey' => $listSurvey,
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
            ], 400);
        }
    }

    public function deleteSurvey(Request $request)
    {
        $surveyId = $request->input('surveyId');
        Survey::find($surveyId)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Delete success',
        ], 200);
    }

    public function changeStateActive(Request $request)
    {
        $surveyId = $request->input('surveyId');
        $active = $request->input('active');
        Log::info($surveyId.$active);
        Survey::where('id',$surveyId)->update(['active' => $active]);
        return response()->json([
            'code' => 200,
            'message' => 'Update success',
        ], 200);
    }


}
