<?php

use App\Http\Controllers\api\v1\TaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/tasks', [TaskController::class, 'index']);
Route::middleware('auth:sanctum')->prefix('/tasks')->group(function () {
    Route::get('/show', [TaskController::class, 'show']);
    Route::put('/update/{task}', [TaskController::class, 'update']);
    Route::delete('/delete/{task}', [TaskController::class, 'destroy']);
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});
