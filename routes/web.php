<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

Route::post('/user', [StudentController::class, 'use']);

#Route::view('admin','admin.dashboard');

#--- Guest ---

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/contact', function () {
        $heading = "<h1>Welcome to Relaxato Contact Page</h1>";
        $contact = 1234567890;
        return view('contact', compact('heading', 'contact'));
    });

    Route::get('/about', function () {
        $heading = "<h1>Welcome to Relaxato About Page</h1>";

        return view('about', compact('heading'));
    });
});

#--- Authentication
/*
Route::controller(LoginController::class)->group(function () {
    Route::view('/login', 'auth.login')->name('login')->middleware('guest');
    Route::post('authenticate', 'authenticate');
    Route::get('logout', 'logout')->middleware('auth');
});*/


Route::group(['middleware' => 'guest'], function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('authenticate', [LoginController::class ,'authenticate']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LoginController::class,'logout']);
});



Route::group(['middleware' => ['guest']], function () {

    Route::controller(ForgotPasswordController::class)->group(function () {

        Route::get('forgot-password', 'showForgotPasswordForm')->name('forgot.password.get');

        Route::post('forgot-password', 'submitForgotPasswordForm')->name('forgot.password.post');

        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');

        Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
    });
});

#--- User ---

Route::view('/student', 'users/user')->middleware('auth', 'student');
Route::view('/user', 'users/profile')->middleware('auth', 'student');
Route::post('/user/{student}/change', [StudentController::class, 'changePassword'])->name('user.change')->middleware('auth', 'student');;

#--- Admin ----


Route::group(['middleware' => ['admin', 'auth']], function () {

    Route::view('/admin', 'admin/dashboard');
    Route::view('/admin/profile', 'admin/profile');
    ROUTE::view('/register', 'admin.register');
    ROUTE::post('store', [RegisterController::class, 'store'])->name('student.store');
    ROUTE::controller(AdminController::class)->group(function () {
        ROUTE::get('/users',  'index')->name('admin.student.index');
        ROUTE::get('/students/{student}/edit', 'edit')->name('student.edit');
        ROUTE::post('/students/{student}', 'update')->name('student.update');
        Route::post('/students/{student}/change',  'changePassword')->name('admin.change');
        ROUTE::get('/search',  'search')->name('student.search');
        Route::get('/students/{student}',  'delete')->name('student.delete');

        #ROUTE::get('/delete_all', [StudentController::class, 'delete_all']);

    });
});





//Resource Route
#Route::resource('student',StudentController::class)->middleware('auth.session');

#--- Agent ----

Route::group(['middleware' => ['agent', 'auth']], function () {

     Route::view('/agent', 'agents/dashboard');
    Route::view('/agent/profile', 'agents/profile');
    ROUTE::view('/add', 'agents.register');
    ROUTE::post('insert', [RegisterController::class, 'insert']);
    ROUTE::controller(AgentController::class)->group(function () {
        ROUTE::get('/agents', 'indexs')->name('agent.student.indexs');
        ROUTE::get('/agents/search', 'search')->name('agent.search');
        ROUTE::get('/agents/{student}/edit', 'edit')->name('agent.edit');
        ROUTE::post('/agents/{student}',  'modify')->name('agent.update');
        Route::get('/agents/{student}',  'setView')->name('agent.delete');
        Route::post('/agents/{student}/change',  'changePassword')->name('agent.change');
    });
});
