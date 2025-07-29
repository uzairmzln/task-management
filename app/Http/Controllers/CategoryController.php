<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    public function add(Request $request){

        $validation = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = auth()->user()->categories()->create([
            'name' => $validation['name'],
        ]);

        return response()->json([
            'message' => 'Category added successfully',
            'category' => $category,
        ], 201);
    }

    public function update(Request $request, $id){
        
        $validation = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $category = auth()->user()->categories()->findorFail($id);

        if($category){

            $category->update([
                'name' => $validation['name'],
            ]);

            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category,
            ], 200);
        }

        return response()->json(['message' => 'Category not found'], 404);
    }

    public function delete($id){

        $category = auth()->user()->categories()->findorFail($id);

        if(!$category){
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
