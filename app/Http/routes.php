<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('stuid/{stuid}/password/{password}', 'ApiController@showJson');

Route::group(['middleware' => ['web']], function () {

    // 运行 $php artisan db:seed 命令向 users 表填入管理员的账号(database\seeds\UserTableSeeder)
    // 此处魔改于 vendor\laravel\framework\src\Illuminate\Routing\Router::auth()
    // 去除了 register 功能
    // showLoginForm, login, logout 方法都位于 Illuminate\Foundation\Auth\AuthenticatesUsers 这个 trait 里
    // guest = RedirectIfAuthenticated
    Route::get('/', 'Auth\AuthController@showLoginForm')->middleware('guest');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::post('/StudentManagementSystem/studentInfo', ['uses' => 'CensusController@studentInfo', 'as' => 'studentInfo']);
    Route::post('/StudentManagementSystem/courseInfo', ['uses' => 'CensusController@courseInfo', 'as' => 'courseInfo']);

    Route::post('/add', ['uses' => 'HomeController@add', 'as' => 'add']);
    Route::post('/queryStuid', ['uses' => 'HomeController@queryStuid', 'as' => 'queryStuid']);
    Route::post('/queryCourseid', ['uses' => 'HomeController@queryCourseid', 'as' => 'queryCourseid']);

    Route::delete('/course/{stuid}/{courseid}', ['uses' => 'HomeController@deleteCourse', 'as' => 'delete']);

    Route::post('/queryStuidNumber', ['uses' => 'HomeController@queryStuidNumber', 'as' => 'queryStuidNumber']);
    Route::post('/queryCourseidNumber', ['uses' => 'HomeController@queryCourseidNumber', 'as' => 'queryCourseidNumber']);
});
