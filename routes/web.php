<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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
//     return view('auth.login');
// });

Route::get('/unauthorized', function () {
    return view('error');
})->name('unauthorized');

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');
Route::post('/load-data', [Controllers\HomeController::class, 'load'])->name('load-data');
Route::get('/campuses', [Controllers\WebController::class, 'index'])->name('index');
Route::post('/index/load', [Controllers\WebController::class, 'load'])->name('index-load');
Route::get('/campus/{id}', [Controllers\WebController::class, 'verify'])->name('verify');
Route::get('/verification', [Controllers\WebController::class, 'verification'])->name('verification');
Route::post('/verification/send-code', [Controllers\WebController::class, 'send_code'])->name('send-code');
Route::post('/verification/verify-email', [Controllers\WebController::class, 'verify_email'])->name('verify-email');
Route::get('/answer-survey', [Controllers\WebController::class, 'answer'])->name('answer-survey');
Route::post('/answer-survey/get-form-data', [Controllers\WebController::class, 'getFormData'])->name('get-form-data');
Route::post('/answer-survey/save-client', [Controllers\WebController::class, 'save'])->name('save-client');

Route::get('/survey-window', [Controllers\WebController::class, 'survey'])->name('survey-window');
Route::post('/survey-window/save-answers', [Controllers\WebController::class, 'save_answers'])->name('save-answers');
Route::post('/survey-window/save-comment', [Controllers\WebController::class, 'save_comment'])->name('save-comment');
Route::post('/survey-window/verify-completed', [Controllers\WebController::class, 'is_completed'])->name('verify-completed');

Route::get('/thank-you', [Controllers\WebController::class, 'thank_you'])->name('thank-you');

Auth::routes();

Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','super_admin'])->group(function () {
    Route::get('/settings/campuses', [Controllers\CampusesController::class, 'index'])->name('campuses');
    Route::post('/settings/campus/load', [Controllers\CampusesController::class, 'load'])->name('campuses-load');
    Route::post('/settings/campus/save', [Controllers\CampusesController::class, 'save'])->name('campus-save');
    Route::post('/settings/campus/delete', [Controllers\CampusesController::class, 'delete'])->name('campus-delete');


    Route::get('/settings/users', [Controllers\UsersController::class, 'index'])->name('users');
    Route::post('/settings/users/save', [Controllers\UsersController::class, 'save'])->name('user-save');
    Route::post('/settings/users/load', [Controllers\UsersController::class, 'load'])->name('users-load');
    Route::post('/settings/users/delete', [Controllers\UsersController::class, 'delete'])->name('user-delete');
    Route::post('/settings/user/deactivate', [Controllers\UsersController::class, 'deactivate'])->name('user-deactivate');
});

Route::middleware(['auth','admin'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/colleges', [Controllers\CollegesController::class, 'index'])->name('colleges');
        Route::post('/college/load', [Controllers\CollegesController::class, 'load'])->name('colleges-load');
        Route::post('/college/save', [Controllers\CollegesController::class, 'save'])->name('college-save');
        Route::post('/college/delete', [Controllers\CollegesController::class, 'delete'])->name('college-delete');

        Route::get('/courses', [Controllers\CoursesController::class, 'index'])->name('courses');
        Route::post('/course/load', [Controllers\CoursesController::class, 'load'])->name('courses-load');
        Route::post('/course/save', [Controllers\CoursesController::class, 'save'])->name('course-save');
        Route::post('/course/delete', [Controllers\CoursesController::class, 'delete'])->name('course-delete');


        Route::get('/offices', [Controllers\OfficesController::class, 'index'])->name('offices');
        Route::post('/offices/load', [Controllers\OfficesController::class, 'load'])->name('offices-load');
        Route::post('/office/save', [Controllers\OfficesController::class, 'save'])->name('office-save');
        Route::post('/office/delete', [Controllers\OfficesController::class, 'delete'])->name('office-delete');

        Route::get('/answers', [Controllers\AnswersController::class, 'index'])->name('answers');
        Route::post('/answers/load', [Controllers\AnswersController::class, 'load'])->name('answers-load');
        Route::post('/answer/save', [Controllers\AnswersController::class, 'save'])->name('answer-save');
        Route::post('/answer/delete', [Controllers\AnswersController::class, 'delete'])->name('answer-delete');

        Route::get('/questions', [Controllers\QuestionsController::class, 'index'])->name('questions');
        Route::post('/questions/load', [Controllers\QuestionsController::class, 'load'])->name('questions-load');
        Route::post('/question/save', [Controllers\QuestionsController::class, 'save'])->name('question-save');
        Route::post('/question/delete', [Controllers\QuestionsController::class, 'delete'])->name('question-delete');
        Route::post('/question/update', [Controllers\QuestionsController::class, 'update'])->name('question-update');

        Route::get('/setting', [Controllers\SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/require-email-verification', [Controllers\SettingsController::class, 'require_email_verification'])->name('require_email_verification');
    });
});
