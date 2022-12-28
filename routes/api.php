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

Route::get( '/', function( Request $request ) {
    return response()->json( [
        'message' => 'Welcome to SMSAvisering API',
        'version' => '1.0.0',
        'author' => '4633.se',
        'base_url' => $request->getUri() . 'api/v1'
    ], 200 );
} )->name('api.welcome');

Route::group( ['prefix' => 'api/v1'], function() {
    Route::get( '/', function() {
        return response()->json( ['message' => 'Welcome to the API'], 200 );
    } )->name('api.index');
    Route::middleware( ['auth:sanctum'] )->group( function() {
        // Get the current authenticated user
        Route::get( '/user', function() {
            return response()->json( auth()->user(), 200 );
        } )->name('api.user');

        // Functions for listing users and update
        Route::group( ['prefix' => 'users'], function() {
            Route::get( '/', function() {
                return response()->json( User::all(), 200 );
            } )->name('api.users.index');
            Route::get( '/{user}', function( $user ) {
                return response()->json( User::find( $user ), 200 );
            } )->name('api.users.show');
        } );
    } );
} );


Route::fallback(function () {
    return response()->json(['error' => 'No resource at the given route. If you believe this error is on our side, please contact an administrator.'], 404);
});
