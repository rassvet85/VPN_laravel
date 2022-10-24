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

Auth::routes();
Route::get('/logout', 'SmartAdmin@logout');

// Render perticular view file by foldername and filename and all passed in only one controller at a time
Route::get('{folder}/{file}', 'SmartAdmin@index');
Route::get('/home', 'SmartAdmin@root');
Route::get('/{filename}', 'SmartAdmin@welcome');

// when render first time project redirect
Route::get('/', function () {
    return redirect('login');
});

// set auth middleware for specific url
// Route::group(['middleware' => 'auth'], function () {
//
// });
