<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KriteriaDuaController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\KriteriaSatuController;
use App\Http\Controllers\KriteriaTigaController;
use App\Http\Controllers\KriteriaEmpatController;
use App\Http\Controllers\KriteriaLImaController;
use App\Http\Controllers\KriteriaEnamController;
use App\Http\Controllers\KriteriaTujuhController;
use App\Http\Controllers\KriteriaDelapanController;
use App\Http\Controllers\KriteriaSembilanController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\UserController;

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

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

// Public routes
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

// Logout (both GET and POST)
Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth.any');

Route::middleware(['auth.any'])->group(function () {
    Route::get('/index', [WelcomeController::class, 'index']);
});

Route::middleware(['auth.superadmin'])->group(function () {
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

Route::middleware(['authorize:KRIT1'])->group(function () {
    Route::group(['prefix' => '/kriteria1'], function () {
        Route::get('/', [KriteriaSatuController::class, 'index']);
        Route::post('/list', [KriteriaSatuController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaSatuController::class, 'create']);
        Route::post('/store', [KriteriaSatuController::class, 'store']);
        Route::get('/{id}/show', [KriteriaSatuController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaSatuController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaSatuController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaSatuController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaSatuController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaSatuController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaSatuController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT2'])->group(function () {
    Route::group(['prefix' => '/kriteria2'], function () {
        Route::get('/', [KriteriaDuaController::class, 'index']);
        Route::post('/list', [KriteriaDuaController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaDuaController::class, 'create']);
        Route::post('/store', [KriteriaDuaController::class, 'store']);
        Route::get('/{id}/show', [KriteriaDuaController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaDuaController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaDuaController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaDuaController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaDuaController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaDuaController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaDuaController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT3'])->group(function () {
    Route::group(['prefix' => '/kriteria3'], function () {
        Route::get('/', [KriteriaTigaController::class, 'index']);
        Route::post('/list', [KriteriaTigaController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaTigaController::class, 'create']);
        Route::post('/store', [KriteriaTigaController::class, 'store']);
        Route::get('/{id}/show', [KriteriaTigaController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaTigaController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaTigaController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaTigaController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaTigaController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaTigaController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaTigaController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT4'])->group(function () {
    Route::group(['prefix' => '/kriteria4'], function () {
        Route::get('/', [KriteriaEmpatController::class, 'index']);
        Route::post('/list', [KriteriaEmpatController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaEmpatController::class, 'create']);
        Route::post('/store', [KriteriaEmpatController::class, 'store']);
        Route::get('/{id}/show', [KriteriaEmpatController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaEmpatController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaEmpatController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaEmpatController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaEmpatController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaEmpatController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaEmpatController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT5'])->group(function () {
    Route::group(['prefix' => '/kriteria5'], function () {
        Route::get('/', [KriteriaLimaController::class, 'index']);
        Route::post('/list', [KriteriaLimaController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaLimaController::class, 'create']);
        Route::post('/store', [KriteriaLimaontroller::class, 'store']);
        Route::get('/{id}/show', [KriteriaLimaController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaLimaController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaLimaController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaLimaController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaLimaController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaLimaController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaLimaController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT7'])->group(function () {
    Route::group(['prefix' => '/kriteria2'], function () {
        Route::get('/', [KriteriaEnamController::class, 'index']);
        Route::post('/list', [KriteriaEnamController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaEnamController::class, 'create']);
        Route::post('/store', [KriteriaEnamController::class, 'store']);
        Route::get('/{id}/show', [KriteriaEnamController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaEnamController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaEnamController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaEnamController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaEnamController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaEnamController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaEnamController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT7'])->group(function () {
    Route::group(['prefix' => '/kriteria2'], function () {
        Route::get('/', [KriteriaTujuhController::class, 'index']);
        Route::post('/list', [KriteriaTujuhController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaTujuhController::class, 'create']);
        Route::post('/store', [KriteriaTujuhController::class, 'store']);
        Route::get('/{id}/show', [KriteriaTujuhController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaTujuhController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaTujuhController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaTujuhController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaTujuhController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaTujuhController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaTujuhController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT7'])->group(function () {
    Route::group(['prefix' => '/kriteria2'], function () {
        Route::get('/', [KriteriaDelapanController::class, 'index']);
        Route::post('/list', [KriteriaDelapanController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaDelapanController::class, 'create']);
        Route::post('/store', [KriteriaDelapanController::class, 'store']);
        Route::get('/{id}/show', [KriteriaDelapanController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaDelapanController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaDelapanController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaDelapanController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaDelapanController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaDelapanController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaDelapanController::class, 'delete']);
    });
});

Route::middleware(['authorize:KRIT7'])->group(function () {
    Route::group(['prefix' => '/kriteria2'], function () {
        Route::get('/', [KriteriaSembilanController::class, 'index']);
        Route::post('/list', [KriteriaSembilanController::class, 'list']);
        // Ajax Tambah
        Route::get('/input', [KriteriaSembilanController::class, 'create']);
        Route::post('/store', [KriteriaSembilanController::class, 'store']);
        Route::get('/{id}/show', [KriteriaSembilanController::class, 'show']);
        Route::get('/preview/{id}', [KriteriaSembilanController::class, 'preview'])->name('preview.ppepp');
        Route::post('/upload', [KriteriaSembilanController::class, 'uploadImage'])->name('image.upload');
        // Ajax Update
        Route::get('/{id}/edit', [KriteriaSembilanController::class, 'edit']);
        Route::put('/{id}/update', [KriteriaSembilanController::class, 'update']);
        // Ajax Delete
        Route::get('/{id}/delete', [KriteriaSembilanController::class, 'confirm']);
        Route::delete('/{id}/delete', [KriteriaSembilanController::class, 'delete']);
    });
});