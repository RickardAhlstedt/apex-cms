<?php

use App\Http\Controllers\AdminController;
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

    Route::get( '/admin/posts', [AdminController::class, 'posts'] )->name('admin.posts');
    Route::get( '/admin/posts/create', [AdminController::class, 'createPost'] )->name('admin.posts.create');

    Route::post( '/admin/posts/create', [AdminController::class, 'storePost'] )->name('admin.posts.store');

    Route::get( '/admin/images', [AdminController::class, 'images'] )->name('admin.images.index');
    Route::get( '/admin/images/{id}', [AdminController::class, 'showImage'] )->name('admin.images.show');
    Route::post( '/admin/images', [AdminController::class, 'storeImage'] )->name('admin.images.upload');
    Route::post( '/admin/images/{id}', [AdminController::class, 'editImage'] )->name('admin.images.update');

    Route::delete( '/admin/images/{id}', [AdminController::class, 'deleteImage'] )->name('admin.images.delete');

    // Route::post( '/admin/images/upload', [AdminController::class, 'dropzoneStore'])->name('admin.images.upload');

} );

Route::group(['middleware' => 'role:user'], function() {
    Route::get( '/home', [HomeController::class, 'index'] )->name('home');
} );


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
