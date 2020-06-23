<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first(),
            ], 200);
        }
        User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'activated'        => User::ACTIVATED,
            'role' => $request->input('role'),
        ]);
        return response()->json([
            'code' => 201,
            'message' => 'Create success',
        ], 200);

    }

    public function get(Request $request)
    {
        $user_id = Auth::id();
        $list = User::all();
        $count = $list->count();
        $list = $list->toArray();
        return response()->json(['items' => $list, 'total' => $count]);
    }

    public function delete(Request $request)
    {
        $idEmail = $request->input('idEmail');
        Email::find($idEmail)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Delete success',
        ], 200);
    }

    public function lock(Request $request)
    {
        $idAccount = $request->input('idAccount');
        User::find($idAccount)->update(['activated' => 0]);
        return response()->json([
            'code' => 200,
        ], 200);
    }

    public function unlock(Request $request)
    {
        $idAccount = $request->input('idAccount');
        User::find($idAccount)->update(['activated' => 1]);
        return response()->json([
            'code' => 200,
        ], 200);
    }
}
