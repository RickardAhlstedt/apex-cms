<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'] )->name('admin.home');

    Route::get( '/admin/users', [AdminController::class, 'users'] )->name('admin.users');
    Route::get( '/admin/users/create', [AdminController::class, 'createUser'] )->name('admin.users.create');

    Route::get( '/admin/books', [BookController::class, 'index'] )->name( 'admin.books' );
    Route::get( '/admin/books/{id}', [BookController::class, 'edit'] )->name( 'admin.books.edit' );

} );

Route::group(['middleware' => 'role:user'], function() {
    Route::get( '/home', [HomeController::class, 'index'] )->name('home');
} );


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
