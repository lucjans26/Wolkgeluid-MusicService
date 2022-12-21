<?php

use App\Http\Controllers\SongController;
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

const ROUTE = '/music';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get(ROUTE, [SongController::class, 'getSong']);
//Route::get('/music/search', [SongController::class, 'searchSong']);
Route::delete(ROUTE, [SongController::class, 'deleteSong']);
Route::post(ROUTE, [SongController::class, 'uploadSong']);
