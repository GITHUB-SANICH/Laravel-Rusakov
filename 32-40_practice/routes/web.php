<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('index');
Route::get('/author', [App\Http\Controllers\MainController::class, 'author'])->name('author');
Route::get('/courses', [App\Http\Controllers\MainController::class, 'courses'])->name('courses');
Route::get('/releases', [App\Http\Controllers\MainController::class, 'releases'])->name('releases');
Route::get('/sites', [App\Http\Controllers\MainController::class, 'sites'])->name('sites');
Route::any('/sites/add', [App\Http\Controllers\MainController::class, 'addSite'])->name('site.add');

Route::any('/post/{alias}', [App\Http\Controllers\MainController::class, 'post'])->name('post');
Route::any('/post/{alias}#comments', [App\Http\Controllers\MainController::class, 'post'])->name('post.comments');
Route::get('/comment{comment}/delete', [App\Http\Controllers\MainController::class, 'deleteComment'])
	->middleware('can:delete,comment')->name('comment.delete');
//поиск
Route::get('/search', [App\Http\Controllers\MainController::class, 'search'])->name('search');


