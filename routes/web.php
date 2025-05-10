<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SuperAdmin\RoleController;

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

Route::pattern('id', '[0-9]+');

// Public routes
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

// Logout (both GET and POST)
Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth.any');

Route::middleware(['auth.superadmin'])->group(function () {
    Route::get('/index', [WelcomeController::class, 'index']);

    Route::group(['prefix' => 'superadmin/user'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        // Ajax Tambah
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/ajax', [UserController::class, 'store']);
        Route::get('/{id}/show', [UserController::class, 'show']);
        // Ajax Update
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}/update', [UserController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [UserController::class, 'confirm']);
        Route::delete('/{id}/delete', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'superadmin/role'], function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/list', [RoleController::class, 'list']);
        // Ajax Tambah
        Route::get('/create', [RoleController::class, 'create']);
        Route::post('/ajax', [RoleController::class, 'store']);
        Route::get('/{id}/show', [RoleController::class, 'show']);
        // Ajax Update
        Route::get('/{id}/edit', [RoleController::class, 'edit']);
        Route::put('/{id}/update', [RoleController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [RoleController::class, 'confirm']);
        Route::delete('/{id}/delete', [RoleController::class, 'delete']);
    });
});
