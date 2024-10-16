<?php

use App\Http\Controllers\KanbanController;
use App\Http\Livewire\KanbanBoard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Kanban\Index;
use App\Http\Livewire\TasklistDetail;

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

Auth::routes(['verify' => true]);

// Route::resource('/kanban', KanbanController::class);
Route::middleware(['auth'])->group(function () {
  Route::get('/project', Index::class)->name('kanban.index');
  Route::get('/tasklist/{encryptedId}', TasklistDetail::class)->name('tasklist.detail');
});

// Route::get('/kanban', KanbanBoard::class)->name('kanban');

Route::get('/test', App\Http\Livewire\KanbanBoard::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// customers route
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.list');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
