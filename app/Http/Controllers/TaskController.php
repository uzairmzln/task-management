<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
 
class TaskController extends Controller
{
    public function add(Request $request, $id){

        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',    
            'status' => 'required|in:pending,completed',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf',
        ],
        [
            'files.*.mimes' => 'Only jpg, jpeg, png, and pdf files are allowed.',
            'files.*.max' => 'Each file must not exceed 2MB.',
        ]);

        $tasks = auth()->user()->categories()->findorFail($id)->tasks()->create([
            'name' => $validation['name'],
            'description' => $validation['description'],
            'status' => $validation['status'],
            'date_from' => $validation['date_from'],
            'date_to' => $validation['date_to'],
        ]);
        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $tasks->addMedia($file)->toMediaCollection('tasks_files');
            }
        }

        return response()->json([
            'message' => 'Task added successfully',
            'task' => $tasks,
            'files' => $tasks->getMedia('tasks_files')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'name' => $media->name,
                ];
            }),
        ], 201);
    }
    
    public function update(Request $request, $category_id, $task_id){

        $validation = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable',    
            'status' => 'sometimes|required|in:pending,completed',
            'date_from' => 'sometimes|nullable|date',
            'date_to' => 'sometimes|nullable|date|after_or_equal:date_from',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf',
        ],
        [
            'files.*.mimes' => 'Only jpg, jpeg, png, and pdf files are allowed.',
            'files.*.max' => 'Each file must not exceed 2MB.',
        ]);

        $category = auth()->user()->categories()->findOrFail($category_id);
        if(!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $tasks = $category->tasks()->findOrFail($task_id);
        if(!$tasks){
            return response()->json(['message' => 'Task not found'], 404);
        }

        $tasks->update([
            'name' => $validation['name'],
            'description' => $validation['description'],
            'status' => $validation['status'],
            'date_from' => $validation['date_from'],
            'date_to' => $validation['date_to'],
        ]);

        if($request->hasFile('files')){
            $media = Media::find($tasks->getMedia('tasks_files')->pluck('id'));
            if ($media){
                foreach ($media as $file) {
                    $file->delete();
                }
            }
            foreach ($request->file('files') as $file) {
                $tasks->addMedia($file)->toMediaCollection('tasks_files');
            }
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $tasks,
        ], 200);

    }

    public function delete($category_id, $task_id){

        $category = auth()->user()->categories()->findOrFail($category_id);
        if(!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        
        $tasks = $category->tasks()->findOrFail($task_id);
        if(!$tasks){
            return response()->json(['message' => 'Task not found'], 404);
        }

        $media = Media::find($tasks->getMedia('tasks_files')->pluck('id'));
        if ($media){
            foreach ($media as $file) {
                $file->delete();
            }
        }
        
        $tasks->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }
}
