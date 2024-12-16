<?php

use App\Http\Controllers\RegistAuthController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Kanban;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Kanban\Index;
use App\Http\Livewire\TasklistDetail;
use App\Http\Livewire\Tim;
use App\Http\Livewire\TimDetail;
use App\Http\Livewire\Tugas;
use App\Http\Livewire\TugasCalendar;
use App\Http\Livewire\User;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/daftar', [RegistAuthController::class, 'index'])->name('register.index');
    Route::post('/daftar', [RegistAuthController::class, 'register'])->name('register.submit');
});

// Route::resource('/kanban', KanbanController::class);
Route::middleware(['auth'])->group(function () {
    // Project
    // Route::get('/project', Index::class)->name('kanban.index');
    // Route::get('/team/{id}/project', Index::class)->name('kanban.index');
    Route::get('/team/{id}/project', Kanban::class)->name('kanban.index');

    // Tasklist
    Route::get('/tasklist/{encryptedId}', TasklistDetail::class)->name('tasklist.detail');

    // User
    Route::get('/user', User::class)->name('user.index');

    // Log
    Route::get('/logs', [App\Http\Livewire\Kanban::class, 'allLogs'])->name('logs');
    Route::get('/log/{tasklist}', [App\Http\Livewire\Kanban::class, 'log'])->name('livewire.log');

    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/', Dashboard::class)->name('root');

    // Tugas
    Route::get('/tugas', Tugas::class)->name('tugas.index');

    // Kalendar
    Route::get('/kalendar', TugasCalendar::class)->name('kalendar.index');

    // Tim
    Route::get('/team', Tim::class)->name('tim.index');
    Route::get('/team/{id}', TimDetail::class)->name('tim.detail');



    Route::get('{any}', Dashboard::class)->name('index');
});



// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// customers route
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.list');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');


//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
