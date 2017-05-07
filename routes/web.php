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

Auth::routes();

Route::get('/', 'IndexController@index');
Route::get('/group', 'GroupController@index');
Route::get('/employee', 'EmployeeController@index');
Route::get('/department', 'DepartmentController@index');
Route::get('/position', 'PositionController@index');

// api
Route::get('/api/user', function () {
    return response()->json([
        'isLogin' => Auth::check() ? 1 : 0
    ]);
});

Route::get('/api/employee/list', 'Api\EmployeeController@index');
Route::get('/api/department/list', 'Api\DepartmentController@index');
Route::get('/api/position/list', 'Api\PositionController@index');
Route::get('/api/group/{year}/{month}/list', 'Api\GroupController@index');
Route::get('/api/group/{year}/{month}/create/{groupNumber}', 'Api\GroupController@create');

// require auth
Route::group(['middleware' => 'auth'], function () {
    // employee
    Route::post('/api/employee', 'Api\EmployeeController@store');
    Route::put('/api/employee/{id}', 'Api\EmployeeController@update');
    Route::delete('/api/employee/{id}', 'Api\EmployeeController@destroy');

    // department
    Route::post('/api/department', 'Api\DepartmentController@store');
    Route::put('/api/department/{id}', 'Api\DepartmentController@update');
    Route::delete('/api/department/{id}', 'Api\DepartmentController@destroy');

    // position
    Route::post('/api/position', 'Api\PositionController@store');
    Route::put('/api/position/{id}', 'Api\PositionController@update');
    Route::delete('/api/position/{id}', 'Api\PositionController@destroy');

    // group
    Route::post('/api/group/{year}/{month}', 'Api\GroupController@store');
    Route::delete('/api/group/{year}/{month}', 'Api\GroupController@destroy');
});
