<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'Top\TopController');

Auth::routes();

Route::prefix('/bookmarks')->group(function () {
    Route::get('/', 'Bookmarks\BookmarkController@list');
    Route::get('/category/{category_id}', 'Bookmarks\BookmarkController@listCategory');
    Route::post('/', 'Bookmarks\BookmarkController@create');
    Route::put('/{id}', 'Bookmarks\BookmarkController@update');
    Route::delete('/{id}', 'Bookmarks\BookmarkController@delete');
});

Route::prefix('/bookmark-create')->group(function () {
    Route::get('/', 'Bookmarks\BookmarkController@showCreateForm');
});
Route::prefix('/bookmark-edit')->group(function () {
    Route::get('/{id}', 'Bookmarks\BookmarkController@showEditForm');
});

Route::prefix('/user')->group(function () {
    Route::get('/profile', 'User\UserController@showProfile');
});