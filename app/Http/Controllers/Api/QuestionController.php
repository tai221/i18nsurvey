<?php

namespace App\Http\Controllers\Api;

use App\Choice;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        $question = Question::updateOrCreate(
            ['id'=> $request->input('questionId')],
            [
                'survey_id' => $request->input('surveyId'),
                'required' => $request->input('required'),
                'type' => $request->input('type'),
                'question' => $request->input('question'),
                'page' => $request->input('page'),
                'order_page' => $request->input('orderPage'),
                ]
        );
        $idQuestion = $question->id;
        $choices = $request->input('answers');

        foreach ($choices as $key => $answer) {
            Choice::updateOrCreate(
                ['id'=> $answer['id']],
                [
                    'content' => $answer['content'],
                    'key' => $key,
                    'question_id' => $idQuestion,
                ]
            );
        }
        $type = $request->input('type');

        if($type == 1) {
            $hiddenOtherAnswer = $request->input('hiddenOtherAnswer');
            $otherAnswer = $request->input('otherAnswer');
            if(!$hiddenOtherAnswer) {
                Choice::updateOrCreate(
                    ['id'=> $otherAnswer['id']],
                    [
                        'content' => $otherAnswer['content'],
                        'key' => 100,
                        'question_id' => $idQuestion,
                    ]
                );
            } else {
                if($otherAnswer['id'] != null)
                Choice::find($otherAnswer['id'])->delete();
            }
        }

        return response()->json([
            'code' => 201,
            'message' => 'Create success',
            'question_id' => $idQuestion,
        ], 200);
    }

    public function fetchListQuestions(Request $request)
    {
        $idSurvey = $request->input('surveyId');
        $pageNumber = $request->input('pageNumber');
        $questions = Question::select('id','required','type','question','order_page')->Where('survey_id', $idSurvey)->Where('page', $pageNumber)->orderBy('order_page','asc')->get()->toArray();
        foreach ($questions as $key => &$question) {
            $answers = Choice::select('content','id','key')->Where('question_id', $question['id'])->orderBy('key','asc')->get()->toArray();
            $question['answers'] = $answers;
        }
        return response()->json([
            'code' => 200,
            'questions' => $questions,
        ], 200);
    }

    public function fetchQuestion(Request $request)
    {
        $idQuestion = $request->input('idQuestion');
        $question = Question::select('id','required','type','question','order_page')->Where('id', $idQuestion)->get()->toArray();
        $answers = Choice::select('content','id','key')->Where('question_id', $idQuestion)->orderBy('key','asc')->get()->toArray();
        $question['answers'] = $answers;
        return response()->json([
            'code' => 200,
            'question' => $question,
        ], 200);
    }

    public function deleteQuestion(Request $request)
    {
        $idQuestion = $request->input('idQuestion');
        Question::find($idQuestion)->delete();
        return response()->json([
            'code' => 200,
        ], 200);
    }

    public function fetchAllQuestions(Request $request)
    {
        $idSurvey = $request->input('surveyId');
        $questions = Question::select('id','required','type','question','order_page', 'page')->Where('survey_id', $idSurvey)->get()->toArray();
        foreach ($questions as $key => &$question) {
            $answers = Choice::select('content','id','key')->Where('question_id', $question['id'])->orderBy('key','asc')->get()->toArray();
            $question['answers'] = $answers;
            $question['tick'] = null;
        }
        $arrPage = array();
        $countPage = Question::select('page')->where('survey_id', $idSurvey)->orderBy('page','desc')->limit(1)->get()->toArray();
        for($i = 0; $i < $countPage[0]['page']; $i++) {
            $temp = array();
            foreach($questions as $key => $value) {
                if($value['page'] == ($i+1)) {
                    array_push($temp, $value);
                }
            }
            $arrPage[$i] = $temp;
        }
        return response()->json([
            'code' => 200,
            'arrPage' => $arrPage,
        ], 200);
    }
}
