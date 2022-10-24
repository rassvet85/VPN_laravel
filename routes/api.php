<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apicontroller;

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

Route::get('/ldap', [Apicontroller::class, 'getLdap']);
Route::get('/ldaprefresh', [Apicontroller::class, 'ldapRefresh']);
Route::get('/ipchange', [Apicontroller::class, 'ipChange']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


