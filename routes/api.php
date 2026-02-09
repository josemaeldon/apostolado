<?php

use App\Http\Controllers\Api\MemberRegistrationController;
use Illuminate\Support\Facades\Route;

// API routes with web authentication (for admin panel usage)
Route::middleware(['auth', 'web'])->prefix('admin')->group(function () {
    Route::apiResource('member-registrations', MemberRegistrationController::class);
});
