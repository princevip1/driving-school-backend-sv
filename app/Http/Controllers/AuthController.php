<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgot_password']]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth('api')->claims(['user' => auth('api')->user()])->attempt($validator->validated());
        return $this->createNewToken($token);

        // return response()->json([
        //     'token' => $this->createNewToken($token),
        // ]);
    }

    public function me()
    {
        // add profile picture url to response
        auth()->user()->profile_picture = url('uploads/student/' . auth()->user()->profile_picture);
        return response()->json(auth()->user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    public function edit_info(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->save();

        $user->profile_picture = url('uploads/student/' . $user->profile_picture);

        return response()->json([
            'message' => 'Your information has been updated',
            'user' => $user,
        ], 201);
    }


    public function refresh()
    {
        return $this->createNewToken(auth::refresh());
    }

    protected function createNewToken($token)
    {
        $user = auth('api')->user();
        $user->profile_picture = url('uploads/student/' . $user->profile_picture);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'user' => $user,
        ]);
    }


    public function forgot_password(Request $request)
    {

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => "We can't find any user in this Email",
                'data' => $email
            ], 400);
        }

        return response()->json([
            'message' => "An email has been sent to the registered email address with instructions on how to reset your password. Please check your inbox and follow the provided link to create a new password. If you don't receive the email within a few minutes, please check your spam folder.",
            'data' => $user
        ], 201);
    }
}
