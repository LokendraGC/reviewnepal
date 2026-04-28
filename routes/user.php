<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;


Route::middleware('auth:sanctum')->group( function () {

    // check current user is logged in or not
    Route::get('me', [AuthenticationController::class, 'me']);

});
