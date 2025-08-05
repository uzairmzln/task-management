<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Verify the hash matches
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return Redirect::to(env('FRONTEND_URL', env('APP_URL')) . '/email-verification-failed');
        }

        // Check if URL is signed and not expired
        if (!URL::hasValidSignature($request)) {
            return Redirect::to(env('FRONTEND_URL', env('APP_URL')) . '/email-verification-expired');
        }

        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return Redirect::to(env('FRONTEND_URL', env('APP_URL')) . '/dashboard?verified=already');
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        // Generate a new token for the user
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Redirect to frontend with token as query parameter
        // The frontend should capture this token and store it
        return Redirect::to(env('FRONTEND_URL', env('APP_URL')) . '/dashboard?token=' . urlencode($token));
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email sent']);
    }
}
