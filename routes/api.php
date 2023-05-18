<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentDownloadController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('quiz', QuizController::class);
Route::post('google', [AuthController::class, 'google']);

Route::post('{quiz}/download', [DocumentDownloadController::class, 'download_request'])->middleware('auth:sanctum');
Route::apiResource('quiz.report', \App\Http\Controllers\ReportController::class)->middleware('auth:sanctum');
Route::get('download', [DocumentDownloadController::class, 'download']);
