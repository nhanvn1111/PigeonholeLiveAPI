<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\RepaymentController;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::middleware('auth:api')->group( function () {
    
    Route::get('loans', [LoanController::class, 'index']);
    Route::post('create/loans', [LoanController::class, 'store']);
    Route::get('loan/{loanid}', [LoanController::class, 'show']);
    Route::post('loan/edit', [LoanController::class, 'edit']);
    Route::post('loan/delete', [LoanController::class, 'destroy']);

    Route::get('repayments', [RepaymentController::class, 'index']);
    Route::post('create/repayment', [RepaymentController::class, 'store']);
    Route::get('repayment/{repaymentid}', [RepaymentController::class, 'show']);
    Route::post('repayment/edit', [RepaymentController::class, 'edit']);
    Route::post('repayment/delete', [RepaymentController::class, 'destroy']);
});