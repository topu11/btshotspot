<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/requestotp', "CustomerController@requestotp");
Route::post('/verifyotp', "CustomerController@verifyotp");
Route::post('/registercustomer', "CustomerController@registercustomer");
Route::post('/getcustomer', "CustomerController@getcustomer");

Route::get('/concheck', "CustomerController@concheck");