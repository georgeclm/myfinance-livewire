<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => $fields['password'],
        ]);



        return $this->login($request);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $input = $request->only('email', 'password');
        $jwt_token = null;
        // check email validity
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user' => $user
        ]);
    }
    public function logout(Request $request)
    {
        // if (!auth()->logout()) {
        //     return response()->json([
        //         'message' => 'Token is required',
        //         'success' => false,
        //     ], 422);
        // }
        // return response()->json([
        //     'success' => true,
        //     'message' => 'User logged out successfully'
        // ]);
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
    public function getCurrentUser(Request $request)
    {
        if (!User::checkToken($request)) {
            return response()->json([
                'message' => 'Token is required'
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();
        // add isProfileUpdated....
        $isProfileUpdated = false;
        // if ($user->isPicUpdated == 1 && $user->isEmailUpdated) {
        //     $isProfileUpdated = true;
        // }
        // $user->isProfileUpdated = $isProfileUpdated;

        return $user;
    }


    public function update(Request $request)
    {
        $user = $this->getCurrentUser($request);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User is not found'
            ]);
        }

        // unset($data['token']);

        // $updatedUser = User::where('id', $user->id)->update($data);
        $user =  User::find($user->id);

        return response()->json([
            'success' => true,
            'message' => 'Information has been updated successfully!',
            'user' => $user
        ]);
    }
}
