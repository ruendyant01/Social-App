<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\FriendRequestController;
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

Route::post("/new-friend", [FriendRequestController::class, "store"]);
Route::patch("/update-friend", [FriendRequestController::class, "updateFriendRequest"]);
Route::get("/all-request/{email}", [FriendRequestController::class, "getUserRequest"]);
Route::get("/all-friend/{email}", [Controller::class, "getUserFriends"]);
Route::post("/common-friend", [Controller::class, "getCommonFriendFromFriends"]);
Route::post("/create-block", [FriendRequestController::class, "blockUserRequest"]);