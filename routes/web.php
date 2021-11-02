<?php

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
Route::group(['namespace' => 'Web'], function() {
    Route::get('/', 'HomeController@index')->name('home');
	Route::group(['prefix' => 'thi-online'], function () {
        Route::get('{grade:slug}', 'CourseController@examByGrade')
            ->name('exam-by-grade');
        Route::get('{grade:slug}/{subject:slug}', 'CourseController@examByGradeSubject')
            ->name('exam-by-grade-subject');
        Route::get('{grade:slug}/{subject:slug}/{chapter:slug}', 'CourseController@examByGradeSubjectChapter')
            ->name('exam-by-grade-subject-chapter');
        Route::get('{grade:slug}/{subject:slug}/{chapter:slug}/{lesson:slug}', 'CourseController@examByGradeSubjectChapterLesson')
            ->name('exam-by-grade-subject-chapter-lesson');
    });
    Route::get('cau-hoi', 'QuestionController@index')
        ->name('question.index');
    Route::get('cau-hoi/{question:id}/{slug?}', 'QuestionController@show')
        ->name('question.show');
	Route::get('search', 'SearchController@search')->name('search');
});
Route::group(['prefix' => '/suggest'], function () {
    Route::get('grades', 'SuggestController@grades')->name('suggest.grades');
    Route::get('subjects', 'SuggestController@subjects')->name('suggest.subjects');
    Route::get('chapters', 'SuggestController@chapters')->name('suggest.chapters');
    Route::get('lessons', 'SuggestController@lessons')->name('suggest.lessons');
    Route::get('users', 'SuggestController@users')->name('suggest.users');
});
