<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\CategoryResource;

class DashboardController extends Controller
{
    public function index() {
        
        $user = auth()->user();
        $category = $user->categories;

        $UserResource = new UserResource($user);
        $CategoryResource = CategoryResource::collection($category);

        return response()->json([
            'message' => 'User Data', 
            'user' => $UserResource,
            'categories' => $CategoryResource,
        ]);
    }

    public function tasks($id) {

        $user = auth()->user();

        $tasks = $user->tasks()->where('category_id', $id)->get();
        if (!$tasks) {
            return response()->json(['message' => 'Tasks null', 200]);
        }

        return response()->json([
            'message' => 'Tasks Data',
            'tasks' => $tasks
        ]);
    }
}
