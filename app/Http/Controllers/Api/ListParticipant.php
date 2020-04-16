<?php

namespace App\Http\Controllers\Api;

use App\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListParticipant extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'code' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first(),
            ], 200);
        }
        Email::create([
           'user_id' => Auth::id(),
           'email' => $request->input('email'),
           'code' => $request->input('code'),
        ]);
        return response()->json([
            'code' => 201,
            'message' => 'Create success',
        ], 200);

    }

    public function get(Request $request)
    {
        $user_id = Auth::id();
        $list = Email::where('user_id', $user_id)->get();
        $count = $list->count();
        $list = $list->toArray();
        return response()->json(['items' => $list, 'total' => $count]);
    }
}
