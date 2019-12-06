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

Route::get('/', function () {
    return view('welcome');
});

Route::get('phpinfo', function () {
    phpinfo();
});
Route::get('text/hello','Test\Admin@Hello');
Route::get('userlogin','UserLogin@addUser');
Route::get('redisq','UserLogin@redisq');
Route::get('addurl','UserLogin@addurl');
Route::get('wx','UserLogin@wx');



