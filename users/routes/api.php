<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'api'], function () {
    // Endpoint to create a new user
    Route::post('/users', [UserController::class, 'createUser']);
});
