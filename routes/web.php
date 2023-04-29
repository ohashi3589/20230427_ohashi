<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TodoController::class, 'index'])->name('index');
Route::get('/create', [TodoController::class, 'create'])->name('create');
Route::post('/store', [TodoController::class, 'store'])->name('store');
Route::post('/todos/{id}', [TodoController::class, 'update'])->name('update');
Route::post('/delete/{todo}', [TodoController::class, 'delete'])->name('delete');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/todos', [TodoController::class, 'index'])->name('todo.index');
Route::post('/logout', function () {
  Auth::logout();
  return redirect('/login');
})->name('logout');
Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])
  ->name('logout.destroy');
Route::get('/logout', function () {
  Auth::logout();
  return redirect('/login');
})->name('logout');
Route::get('/find', [TodoController::class, 'find'])->name('find.index');
Route::get('/todos/search', [TodoController::class, 'search'])->name('search');
Route::patch('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');

