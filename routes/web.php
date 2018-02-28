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

Route::get('/', 'PagesController@guest_page');
Route::get('/home', 'PagesController@getHome')->middleware('auth');
Route::get('/settings/{id}', 'PagesController@getSettings')->middleware('auth');
<<<<<<< HEAD
Route::get('/setting/category', 'PagesController@getCategory')->middleware('admin');
Route::get('/setting/priority', 'PagesController@getPriority')->middleware('admin');
Route::get('/setting/status', 'PagesController@getStatus')->middleware('admin');
Route::get('/setting/user', 'PagesController@getUser')->middleware('admin');
=======
Route::get('/setting/category', 'PagesController@getCategory')->middleware('auth');//admin
Route::get('/setting/priority', 'PagesController@getPriority')->middleware('auth');//admin
Route::get('/setting/status', 'PagesController@getStatus')->middleware('auth');//admin
Route::get('/setting/user', 'PagesController@getUser')->middleware('auth');//admin
>>>>>>> 5d057911946ccdbcfa0d5c8ab5ca298238cbcc1a
Route::get('/export_to_excel', 'PagesController@exportToExcel')->middleware('auth');
Route::get('/close_request/{id}', 'PagesController@closeReq')->middleware('auth');
Route::get('/print_request/{id}', 'PagesController@printReq')->middleware('auth');
Route::post('/export_data', 'ExportedDataController@store')->middleware('auth');

//Route::resource('api/usersextended', 'ApiUsersExtendedController');
//Route::resource('api/users', 'ApiUsersController');
//Route::resource('api/usertypes', 'UserTypesController');
//Route::resource('api/statuses', 'StatusesController');

Route::group(['middleware' => 'auth'], function() {
  Route::resource('api/statuses', 'StatusesController');
  Route::resource('api/usersextended', 'ApiUsersExtendedController');
  Route::resource('api/usertypes', 'UserTypesController');
  Route::resource('api/users', 'ApiUsersController');
});

// middlewares are in controller for excepting index
Route::resource('api/categories', 'CategoryController');
Route::resource('api/requests', 'RequestsController');
Route::resource('api/priorities', 'PriorityController');

Auth::routes();
