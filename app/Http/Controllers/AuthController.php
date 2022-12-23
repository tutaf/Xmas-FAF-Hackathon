<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
           return $this->sendResponse(401, 'Unauthorized', []);
        }

        $user = Auth::user();

        return $this->sendResponse('200', 'success', [
            'user' => $user,
        ], $token);

    }

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('401', $validator->errors()->first(), []);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return $this->sendResponse('200', 'User created successfully', [
            'user' => $user,
        ], $token);
    }

    public function logout()
    {
        Auth::logout();

        return $this->sendResponse('200', 'Successfully logged out', []);
    }

    public function refresh()
    {
        return $this->sendResponse('200', 'Successfully refreshed', [
            'user' => Auth::user(),
        ], Auth::refresh());
    }

}
