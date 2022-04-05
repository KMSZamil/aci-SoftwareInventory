<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\UserManagerController;
use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes(['authenticate' => false]);

    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [AuthenticateController::class, 'login'])->name('authenticate.login');
    Route::prefix('authenticate')->group(function () {
        Route::get('/dashboard', [AuthenticateController::class, 'dashboard'])->name('dashboard');
        Route::get('/login', [AuthenticateController::class, 'login'])->name('authenticate.login');
        Route::post('/make_login', [AuthenticateController::class, 'make_login'])->name('authenticate.make_login');
        Route::get('/register', [AuthenticateController::class, 'register'])->name('authenticate.register');
        Route::post('/make_register', [AuthenticateController::class, 'make_register'])->name('authenticate.make_register');
        Route::post('/logout', [AuthenticateController::class, 'logout'])->name('authenticate.logout');
        Route::get('/pass_change', [AuthenticateController::class, 'pass_change'])->name('authenticate.pass_change');
        Route::post('/pass_change_submit', [AuthenticateController::class, 'pass_change_submit'])->name('authenticate.pass_change_submit');
    });
    Route::resource('samples', SampleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('usermanager', UserManagerController::class);

    Route::resource('projects', ProjectController::class);
    Route::get('/my_project', [MyProjectController::class, 'index'])->name('my_project.index');
    Route::get('/{id}/edit', [MyProjectController::class, 'edit'])->name('my_project.edit');
    Route::post('/update/{id}', [MyProjectController::class, 'update'])->name('my_project.update');
    Route::post('/destroy/{id}', [MyProjectController::class, 'destroy'])->name('my_project.destroy');
    Route::get('/platform_wise/{id}', [MyProjectController::class, 'platform_wise'])->name('my_project.platform_wise');

});

Route::get('/project_export', [ProjectController::class, 'project_export'])->name('excel.project_export');
Route::get('/my_project_export', [MyProjectController::class, 'my_project_export'])->name('excel.my_project_export');
