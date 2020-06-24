<?php

namespace App\Http\Controllers\Api;

use App\Choice;
use App\Email;
use App\Mail\ShareSurvey;
use App\Question;
use App\Respondent;
use App\Response;
use App\Survey;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $listSurvey = Survey::Where('user_id', $userId)->get()->toArray();
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
        $emailId = $request->input('emailId');
        if(is_numeric($emailId)) {
            $respondent = Respondent::create(['survey_id' => $surveyId, 'email_id'=> $emailId]);
            \App\ShareSurvey::Where('email_id', $emailId)->update(['is_submit'=>1]);
        } else {
            $respondent = Respondent::create(['survey_id' => $surveyId]);
        }
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
            $emailId = $respondent['email_id'];
            if(is_numeric($emailId)) {
                $respondent['email_id'] = (Email::select('email')->Where('id', $emailId)->first()->toArray())['email'];
            }
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

    public function shareSurvey(Request $request)
    {
        $userId = Auth::id();
        $user = User::select('email','name')->where('id', $userId)->first()->toArray();
        $data = [];
        $data['sender'] = $user['email'];
        $data['username'] = $user['name'];
        $surveyId = $request['surveyId'];
        $surveyTitle = Survey::select('title')->where('id',$surveyId)->first()->toArray();
        $data['surveyTitle'] = $surveyTitle['title'];
        $listEmail = $request['listEmail'];
        $listIdEmail = $request['listIdEmail'];
        foreach ($listIdEmail as $key => $idEmail) {
            $data['linkSurvey'] = 'http://127.0.0.1:8000/survey/'.$idEmail.'/'.$surveyId;
            Mail::to($listEmail[$key])->send(new ShareSurvey($data));
        }
        $listEmailHasSend = array();
        foreach ($listIdEmail as &$email) {
            $temp = array();
            $temp['survey_id'] = Intval($surveyId);
            $temp['email_id'] = $email;
            $temp['is_send'] = 1;
            $temp['is_submit'] = 0;
            array_push($listEmailHasSend, $temp);
        }
        \App\ShareSurvey::insert($listEmailHasSend);
    }

    public function analytic(Request $request)
    {
        $surveyId = $request['surveyId'];
        $listQuestion = Question::select('id','question','required','type')
            ->Where('survey_id', $surveyId)
            ->orderBy('page','asc')
            ->orderBy('order_page','asc')
            ->get()->toArray();
        foreach ($listQuestion as  &$question) {
            $question['listChoice'] = Choice::select('key','content')->Where('question_id', $question['id'])->get()->toArray();
            $question['arrChoice']['labels'] = array();
            $question['arrCnt'] = array();
            if($question['type'] == 1) {
                foreach ($question['listChoice'] as &$choice) {
                    $key = $choice['key'];
                    if($key!==100){
                        $choice['cnt'] = Response::Where('question_id', $question['id'])->where('answer', strval($key))->get()->count();
                    } else {
                        Log::info('vao day');
                        $choice['cnt'] = Response::Where('question_id', $question['id'])->whereNotIn('answer', ['0','1','2','3','4','5'])->get()->count();
                    }
                    array_push($question['arrChoice']['labels'], $choice['content']);
                    array_push($question['arrCnt'], $choice['cnt']);
                }
            }
        }
        Log::info($listQuestion);
        return response()->json([
            'code' => 200,
            'listQuestion' => $listQuestion,
        ], 200);

    }
}
