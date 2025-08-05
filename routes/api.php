<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MailController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::controller(MailController::class)->group(function (){

    Route::get('/email/verify/{id}/{hash}', 'verify')
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/resend', 'resendVerificationEmail')
        ->middleware('auth:sanctum')
        ->name('verification.send');
});


Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::controller(CategoryController::class)->group(function (){
        Route::post('/category/add', 'add');
        Route::post('/category/update/{id}', 'update');
        Route::delete('/category/delete/{id}', 'delete');
    });

    Route::controller(TaskController::class)->group(function (){
        Route::post('/task/add/{id}', 'add');
        Route::post('/category/{category_id}/task/update/{task_id}', 'update');
        Route::delete('/category/{category_id}/task/delete/{task_id}', 'delete');
    });
});