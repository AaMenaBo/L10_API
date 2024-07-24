<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;


Route::get('/', function () {
    return view('welcome');
});


//Rutas de Tareas
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create']);
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show')->middleware('auth')->can('view', 'task');
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('auth')->can('update', 'task');      
Route::put('/tasks/{task}', [TaskController::class, 'update']);
Route::put('/tasks/complete/{task}', [TaskController::class, 'complete'])->name('tasks.complete');
Route::delete('/tasks/{task}', [TaskController::class, 'delete'])->name('tasks.delete');

//Rutas de Login y Register
Route::get('/register', [RegisterUserController::class, 'create'])->name('register.create');    
Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');

Route::get('/login', [SessionController::class, 'create'])->name('login.create');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::get('/logout', [SessionController::class, 'destroy'])->name('logout');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');