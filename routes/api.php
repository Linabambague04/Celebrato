<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventServiceController;
use App\Http\Controllers\EventSecurityController;
use App\Http\Controllers\EventResourceController;
use App\Http\Controllers\ActivityEventController;
use App\Http\Controllers\FeedbackController;

Route::apiResource('users', UserController::class);
Route::apiResource('supports', SupportController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('notifications', NotificationController::class);
Route::apiResource('messages', MessageController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('eventServices', EventServiceController::class);
Route::apiResource('eventSecurities', EventSecurityController::class);
Route::apiResource('eventResources', EventResourceController::class);
Route::apiResource('activityEvents', ActivityEventController::class);
Route::apiResource('feedbacks', FeedbackController::class);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
