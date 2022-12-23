<?php


namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error', $validator->errors()->first(), []);
        }

        $token = Str::random(64);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'access_token' => $token
        ]);

        $user->save();

        return $this->sendResponse(201, 'success', 'User created successfully', [
            'user' => $user,
        ], $token);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error', $validator->errors()->first(), []);
        }

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $user->access_token = Str::random(64);
        $user->save();

        $token = $user->access_token;

//        if ($request->remember_me){
//            $token->expires_at = Carbon::now()->addWeeks(1);
//        }

//        $token->save();

        return $this->sendResponse(201, 'success','Log in successfully', [
            'user' => $user,
        ], $token);

    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string|min:64',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401, 'error','Undefined token', []);
        }

        $user = User::where('access_token', $request->access_token)->first();

        if ($user) {
            $user->access_token = '';
            $user->save();
        }

        return $this->sendResponse(200, 'success','Successfully logged out', []);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string|min:64',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(401,'error', 'Undefined token', []);
        }

        $user = User::where('access_token', $request->access_token)->first();
        if (!$user) {
            return $this->sendResponse(200,'error', 'User not found', []);
        }
        return $this->sendResponse(201, 'User info', [
            'user' => $user,
        ], $request->access_token);
    }
}

