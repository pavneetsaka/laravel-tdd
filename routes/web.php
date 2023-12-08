<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function(){

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::group(['middleware' => ['auth']], function(){

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [LoginController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('store.user');
        Route::get('/users/create', [UserController::class, 'create'])->name('create.user');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit.user');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('update.user');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('delete.user');

        Route::get('/roles', [RoleController::class, 'index'])->name('roles');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('create.role');
        Route::post('/roles', [RoleController::class, 'store'])->name('store.role');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('edit.role');
        Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('update.store');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('delete.role');

        Route::get('/modules', [ModuleController::class, 'index'])->name('modules');
        Route::get('/modules/create', [ModuleController::class, 'create'])->name('create.module');
        Route::post('/modules', [ModuleController::class, 'store'])->name('store.module');
        Route::get('/modules/{module}/edit', [ModuleController::class, 'edit'])->name('edit.module');
        Route::patch('/modules/{module}', [ModuleController::class, 'update'])->name('update.module');
        Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('delete.module');
    });
});
