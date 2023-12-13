<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TruckingController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/edit-info', [AuthController::class, 'edit_info'])->name("edit-info");
    Route::post('/forgot-password', [AuthController::class, 'forgot_password'])->name("forgot_password");
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'teacher'
], function ($router) {
    Route::get('/', [ApiController::class, 'getAllTeacher']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'course'
], function ($router) {
    Route::get('/', [CourseController::class, 'getAllCourse']);
    Route::get('/duration', [CourseController::class, 'getAllCourseDuration']);
    Route::get('/your-course', [CourseController::class, 'getYourCourse']);
    Route::get('/{id}', [CourseController::class, 'getOneById']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'contact-us'
], function ($router) {
    Route::post('/', [ApiController::class, 'store_contact_us']);
    Route::get('/', [ApiController::class, 'get_contact_us']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'notification'
], function ($router) {
    Route::get('/', [ApiController::class, 'get_notification']);
    Route::get('/{id}', [ApiController::class, 'read_notification']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'leave'
], function ($router) {
    Route::get('/', [ApiController::class, 'get_leave']);
    Route::post('/', [ApiController::class, 'create_leave']);
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'invoice'
], function ($router) {
    Route::get('/', [ApiController::class, 'get_invoice']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'trucking-activity'
], function ($router) {
    Route::post('/update', [TruckingController::class, 'update_trucking_activity']);
    Route::get('/previous', [TruckingController::class, 'previous_trucking_activity']);
    Route::get('/history', [TruckingController::class, 'trucking_activity_history']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'payment'
], function ($router) {
    Route::get('/', [PaymentController::class, 'get_all_payment']);
    Route::post('/create-payment', [PaymentController::class, 'create_payment']);
    Route::post('/update-payment', [PaymentController::class, 'update_payment']);
    Route::post('/create-stripe-payment-intent', [PaymentController::class, 'createPaymentIntent']);
    Route::post('/update-payment-stripe', [PaymentController::class, 'update_payment_stripe']);
});
