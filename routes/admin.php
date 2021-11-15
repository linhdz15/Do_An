<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified', 'dashboard'])->group(function () {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::resource('grades', 'GradeController');
    Route::patch('grades/{grade}/change-status', 'GradeController@changeStatus')->name('grades.change-status');
    Route::resource('subjects', 'SubjectController');
    Route::patch('subjects/{subject}/change-status', 'SubjectController@changeStatus')->name('subjects.change-status');
    Route::resource('chapters', 'ChapterController');
    Route::resource('lessons', 'LessonController');

    Route::resource('users', 'UserController');
    Route::patch('users/{user}/change-status', 'UserController@changeStatus')->name('users.change-status');


    Route::resource('courses', 'CourseController');
    Route::post('courses/{course}/change-status', 'CourseController@changeStatus');

    Route::group(['prefix' => 'courses/{course}'], function () {
        Route::group(['prefix' => 'curriculums'], function () {
            Route::get('/', 'CurriculumController@index')->name('curriculums.index');
            Route::get('{curriculum}/questions', 'CurriculumController@getQuestions');
            Route::post('/', 'CurriculumController@store')->name('curriculums.store');
            Route::post('/{curriculum}', 'CurriculumController@update')->name('curriculums.update');
            Route::delete('/{curriculum}', 'CurriculumController@destroy')->name('curriculums.destroy');
        });

        Route::group(['prefix' => 'questions'], function () {
            Route::post('/', 'QuestionController@store')->name('questions.store');
            Route::post('/{question}', 'QuestionController@update')->name('questions.update');
            Route::delete('/{question}', 'QuestionController@destroy')->name('questions.destroy');
        });

        Route::post('sort-curriculums', 'CurriculumController@sort')->name('curriculums.sort');
        Route::post('sort-questions', 'QuestionController@sort')->name('questions.sort');
    });

    Route::get('statistics', 'StatisticsController@index')->name('statistics');
});
