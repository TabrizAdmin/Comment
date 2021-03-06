<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->as('api.')->namespace('API')->group(function () {
    Route::get('get-comments', [App\Http\Controllers\API\CommentController::class, 'getComments'])->name('get.comments');
    Route::post('send-comment', [App\Http\Controllers\API\CommentController::class, 'sendComment'])->name('send.commnent');
});
