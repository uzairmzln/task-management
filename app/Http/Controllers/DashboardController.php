<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class DashboardController extends Controller
{
    public function index() {
        
        $user = auth()->user();

        $UserResource = new UserResource($user);
        
        return response()->json(['message' => 'User Data', 'user' => $UserResource]);
    }
}
