<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
        ]);

        if ($user){

            event(new Registered($user));
            
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully. Please check your email to verify your account.',
                'user' => $user,
                'token' => $token,
                'email_verification_required' => true
            ], 201);
        }

        return response()->json(['message' => 'User registration failed'], 500);        
    }

    public function login(Request $request)
    {
        // Validate the request
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validation['email'])->first();

        if (!$user || !Hash::check($validation['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }
        
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);

    }

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the user
        $userToken = $request->user()->currentAccessToken()->delete();
        if (!$userToken) {
            return response()->json(['message' => 'Logout failed'], 500);
        }

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function forgotPassword(Request $request) {

        $request->validate([
            'email' => 'required|email'
        ]);

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return env('APP_URL') . '/reset-password?token=' . $token . '&email=' . urlencode($user->email);
        });
    
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'message' => __($status),
            'status' => $status,
        ]);
    }

    public function resetPassword(Request $request) {

        $validation = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(

            $request->only('email', 'password', 'password_confirmation', 'token'),

            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        return response()->json([
            'message' => __($status),
            'status' => $status,
        ]);
    }
}
