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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/music', [SongController::class, 'getSong']);
//Route::get('/music/search', [SongController::class, 'searchSong']);
//Route::put(ALBUM_ROUTE, [SongController::class, 'updateAlbum'])->middleware(['auth:sanctum', 'abilities:music']);
Route::delete('/music', [SongController::class, 'deleteSong']);
Route::post('/music', [SongController::class, 'uploadSong']);
