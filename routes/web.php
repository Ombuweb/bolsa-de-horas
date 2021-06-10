<?php

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
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{client}', [ClientController::class, 'show']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::patch('/clients/{client:slug}', [ClientController::class, 'update']);
    Route::delete('/clients/{client}', [ClientController::class, 'destroy']);
    
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project:slug}',[ ProjectController::class, 'show']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::patch('/projects/{project:slug}',[ ProjectController::class, 'update']);
    Route::delete('/projects/{project:slug}',[ ProjectController::class, 'destroy']);
    
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
