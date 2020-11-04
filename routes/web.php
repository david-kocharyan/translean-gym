<?php

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


/**
 * User authentication
 */
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

/**
 * Admin Login part
 */
Route::get('/login', 'Auth\LoginController@showAdminLoginForm')->name('admin_login_view');
Route::post('/login', 'Auth\LoginController@adminLogin')->name('admin_login');
Route::post('/logout', 'Auth\LoginController@adminLogout')->middleware('auth:admin');

/**
 * All admin route
 */
Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    Route::resource('/', 'AdminsController');

    Route::resource('/users', 'UserController');
    Route::resource('/activities', 'ActivityController');
    Route::resource('/foods', 'FoodController');
    Route::resource('/meals', 'MealController');

//    assessments part
    Route::get('/assessments/{id}', 'UserAssessmentsController@index');
    Route::post('/assessments/{id}', 'UserAssessmentsController@store');
    Route::post('/summary/assessments', 'UserAssessmentsController@summary');
    Route::post('/getAssessment', 'UserAssessmentsController@getAjax');
    Route::post('/deleteAssessment', 'UserAssessmentsController@deleteAssessment');
    Route::get('/assessments/edit/{id}', 'UserAssessmentsController@edit');
    Route::put('/assessments/update/{id}', 'UserAssessmentsController@update');
    Route::get('/assessments/show/{id}', 'UserAssessmentsController@show');

//    day view part
    Route::get('/day/{id}', 'DayController@testIndex');
    Route::post('/day/get-all-data', 'DayController@getAllData');

    Route::post('/day/add-activity', 'DayController@addActivity');
    Route::post('/day/delete-activity', 'DayController@deleteActivity');
    Route::post('/day/edit-activity', 'DayController@editActivity');
    Route::post('/day/clear-all-activities', 'DayController@clearAllActivity');
    Route::post('/day/duplicate-activities', 'DayController@duplicateActivity');

    Route::post('/day/calculate-protein-limit', 'DayController@calculateProteinMustEat');

    Route::post('/day/add-meals', 'DayController@addMeal');
    Route::post('/day/create-meals', 'DayController@createMeal');
    Route::post('/day/get-meal-ajax', 'DayController@getMealAjax');
    Route::post('/day/clear-all-meals', 'DayController@clearMeal');
    Route::post('/day/duplicate-meals', 'DayController@duplicateMeal');
    Route::post('/day/delete-meals', 'DayController@deleteMeal');
    Route::post('/day/edit-meals', 'DayController@editMeal');

    Route::post('/day/add-water', 'DayController@addWater');
    Route::post('/day/edit-water', 'DayController@editWater');
    Route::post('/day/delete-water', 'DayController@deleteWater');

//    day view export part
    Route::get('day/export-view/{id}', 'ExportController@index');
    Route::get('day/export/{id}', 'ExportController@download');

    Route::get('/day-test/{id}', 'DayController@testIndex');
    Route::resource('/met-range', 'MetRangeController');
});
