<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function(){
    Route::get('/users-create', [RegisteredUserController::class, 'create'])->name('users-create');
    Route::get('/users', [RegisteredUserController::class, 'index']);
    Route::delete('/users/{user}', [RegisteredUserController::class, 'destroy']);

    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients-create', [ClientController::class, 'create'])->name('clients-create');
    Route::get('/clients/{client:slug}', [ClientController::class, 'show']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/clients-edit/{client:slug}', [ClientController::class, 'edit']);
    Route::patch('/clients/{client:slug}', [ClientController::class, 'update']);
    Route::delete('/clients/{client:slug}', [ClientController::class, 'destroy']);
    
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects-create/{client:slug}',[ ProjectController::class, 'create']);
    Route::get('/projects/{project:slug}',[ ProjectController::class, 'show']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects-edit/{project:slug}',[ ProjectController::class, 'edit']);
    Route::patch('/projects/{project:slug}',[ ProjectController::class, 'update']);
    Route::delete('/projects/{project:slug}',[ ProjectController::class, 'destroy']);
    
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks-create/{project:slug}', [TaskController::class, 'create']);
    Route::get('/tasks-edit/{task}', [TaskController::class, 'edit']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'can:create,App\Models\Client'])->name('dashboard');

require __DIR__.'/auth.php';
