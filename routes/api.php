<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller('\App\Http\Controllers\Api\AuthController')->group(function () {
    Route::post('login', 'login')->middleware("throttle:5,1");; // login
});

Route::controller('\App\Http\Controllers\Api\UserController')->group(function () {
    Route::post('register', 'register');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resources([
        'company' => CompanyController::class,
        'employee' => EmployeeController::class,
    ]);
});