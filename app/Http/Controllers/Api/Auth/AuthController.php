<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
//Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp(Request $request) {
        $rules = [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "code"    => 400,
                "message" => $validator->errors()->first(),
            ], 200);
        }
        $user = User::create([
            'name'             => explode("@", $request->input('email'))[0],
            'email'            => $request->input('email'),
            'role'             => User::ADMIN,
            'password'         => Hash::make($request->input('password')),
            'activated'        => User::ACTIVATED,
//            'lang_setting' => $request->input('lang_setting'),
        ]);
        return response()->json([
            'code'    => 200,
            'message' => trans('auth.createdUser'),
        ], 200);
    }

    public function login(Request $request)
    {
        $username = $request['username'];
        $password = $request['password'];
        try {
            $request->request->add([
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'name' => $username,
                'password' => $password,
                'scope' => '*'
            ]);
            $tokenRequest = Request::create(
                config('services.passport.login_endpoint'),
                'post'
            );
            $user = User::where('name',$username)->get()->toArray();
            $response = Route::dispatch($tokenRequest);
            return $response;
        } catch (BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }
    public function logout(){
        if (Auth::check()) {
//            auth()->user()->tokens->each(function ($token, $key) {
//                $token->delete();
//            });
            auth()->user()->token()->revoke();
        }
        return response()->json('logout success!', 200);
    }

    public function getUserInfo() {
        $userId = Auth::id();
        $role = User::select('role')->where('id', $userId)->get();
        return response()->json([
            'code' => 200,
            'role' => $role,
        ], 200);
    }
}
