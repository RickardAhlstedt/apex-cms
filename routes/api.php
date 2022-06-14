<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\ImageController;
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

Route::middleware( ['auth:sanctum'] )->group( function() {
    Route::get( 'v1/admin/images/folders', [ ImageController::class, 'getFolders' ] );
    Route::post( 'v1/admin/images/folders', [ImageController::class, 'createFolder'] );
} );

Route::get( 'v1/admin/blocks/template/{template}', [BlockController::class, 'getTemplate'] );

Route::fallback(function () {
    return response()->json(['error' => 'No resource at the given route. If you believe this error is on our side, please contact an administrator.'], 404);
});
