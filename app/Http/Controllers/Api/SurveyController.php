<?php

namespace App\Http\Controllers\Api;

use App\Choice;
use App\Question;
use App\Respondent;
use App\Response;
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
        return response()->json([
            'code' => 200,
            'survey' => $survey,
        ], 200);
    }

    public function countPage(Request $request)
    {
        $surveyId = $request['id'];
        $countPage = Question::select('page')->where('survey_id', $surveyId)->orderBy('page','desc')->limit(1)->get();
        return response()->json([
            'code' => 200,
            'countPage' => $countPage,
        ], 200);
    }

    public function getListSurvey(Request $request)
    {
        $userId = Auth::id();
        $listSurvey = Survey::all()->where('user_id', $userId)->toArray();
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
        Survey::where('id',$surveyId)->update(['active' => $active]);
        return response()->json([
            'code' => 200,
            'message' => 'Update success',
        ], 200);
    }

    public function submit(Request $request)
    {
        $surveyId = $request->input('surveyId');
        $allResponse = $request->input('allResponse');
        $respondent = Respondent::create(['survey_id' => $surveyId]);
        $respondentId = $respondent->id;
        foreach ($allResponse as $key => &$response) {
            $response['respondent_id'] = $respondentId;
        }
        Response::insert($allResponse);
        return response()->json([
            'code' => 200,
            'message' => 'Update success',
        ], 200);
    }

    public function getAllResponse(Request $request)
    {
        $surveyId = $request['surveyId'];
        $listQuestion = Question::select('question','required','type','created_at')
            ->Where('survey_id', $surveyId)
            ->orderBy('page','asc')
            ->orderBy('order_page','asc')
            ->get()->toArray();
        $listRespondent = Respondent::Where('survey_id',$surveyId)->get()->toArray();
        foreach ($listRespondent as $key => &$respondent) {
            $respondentId= $respondent['id'];
            $listResponse = Response::select('question_id', 'answer')
                ->where('respondent_id', $respondentId)
                ->orderBy('id','asc')
                ->get()->toArray();
            foreach ($listResponse as &$response) {
                $questionId = $response['question_id'];
                $question = Question::Where('id', $questionId)->first();
                $typeQuestion = $question['type'];
                $response['setup'] = 0;
                if($typeQuestion == 1 && (is_numeric($response['answer'])))    {
                    $content = Choice::select('content')->Where('question_id',$response['question_id'])->Where('key',$response['answer'])->first();
                    $response['answer'] = $content->content;
                    $response['setup'] = 1;
                }
                if($response['answer'] ==''){
                    $response['setup'] = 1;
                }
            }
            $respondent['listResponse'] = $listResponse;
        }
        return response()->json([
            'code' => 200,
            'listQuestion' => $listQuestion,
            'listRespondent' => $listRespondent,
        ], 200);
    }
}
