<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TermsController;
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

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

Auth::routes(
    [
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]
);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');





// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// group route for admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    // privacy and terms
    Route::get('/privacy', [PrivacyController::class, 'index'])->name('admin.privacy');
    Route::post('/privacy', [PrivacyController::class, 'store'])->name('admin.privacy.store');
    Route::get('/terms', [TermsController::class, 'index'])->name('admin.terms');
    Route::post('/terms', [TermsController::class, 'store'])->name('admin.terms.store');

    // user
    Route::group(
        ['prefix' => 'user', 'as' => 'user.'],
        function () {
            Route::get('/', [UserController::class, 'index'])->name('list');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'student', 'as' => 'student.'],
        function () {
            Route::get('/', [StudentController::class, 'index'])->name('list');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::post('/store', [StudentController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [StudentController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [StudentController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'teacher', 'as' => 'teacher.'],
        function () {
            Route::get('/', [TeacherController::class, 'index'])->name('list');
            Route::get('/create', [TeacherController::class, 'create'])->name('create');
            Route::post('/store', [TeacherController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [TeacherController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [TeacherController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'course', 'as' => 'course.'],
        function () {
            Route::get('/', [CourseController::class, 'index'])->name('list');
            Route::get('/create', [CourseController::class, 'create'])->name('create');
            Route::post('/store', [CourseController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CourseController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CourseController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'contact', 'as' => 'contact.'],
        function () {
            Route::get('/', [ContactController::class, 'index'])->name('list');
            Route::get('/create', [ContactController::class, 'create'])->name('create');
            Route::post('/store', [ContactController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ContactController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [ContactController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'contect_us', 'as' => 'contect_us.'],
        function () {
            Route::get('/', [ContactUsController::class, 'index'])->name('list');
            Route::get('/delete/{id}', [ContactUsController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'gateway', 'as' => 'gateway.'],
        function () {
            Route::get('/', [GatewayController::class, 'index'])->name('list');
            Route::get('/create', [GatewayController::class, 'create'])->name('create');
            Route::post('/store', [GatewayController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [GatewayController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [GatewayController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [GatewayController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'history', 'as' => 'history.'],
        function () {
            Route::get('/', [HistoryController::class, 'index'])->name('list');
            Route::get('/create', [HistoryController::class, 'create'])->name('create');
            Route::post('/store', [HistoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [HistoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [HistoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [HistoryController::class, 'destroy'])->name('delete');
        }
    );
    Route::group(
        ['prefix' => 'leave', 'as' => 'leave.'],
        function () {
            Route::get('/', [LeaveController::class, 'index'])->name('list');
            Route::get('/approve/{id}', [LeaveController::class, 'approve'])->name('approve');
            Route::get('/reject/{id}', [LeaveController::class, 'reject'])->name('reject');
        }
    );
    Route::group(
        ['prefix' => 'payment', 'as' => 'payment.'],
        function () {
            Route::get('/payment', [PaymentHistoryController::class, 'index'])->name('payment.list');
            Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.list');
            Route::get('/payment/view/{id}', [PaymentHistoryController::class, 'view'])->name('payment.view');
            Route::get('/invoice/view/{id}', [InvoiceController::class, 'view'])->name('invoice.view');
        }
    );
});
