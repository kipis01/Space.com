<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\WikiController;

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

Route::redirect('/', '/news');

Route::resource('forum', ForumController::class);
Route::post('forum', [ForumController::class, 'store'])->name('NewForumPost');
Route::get('/forum/{id}', [ForumController::class, 'show']);
Route::post('/forum/{id}', [ForumController::class, 'storeComment']);

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/search', [NewsController::class, 'search'])->name('newsSearch');
Route::get('/news/{id}', [NewsController::class, 'show'])->where('id', '[0-9]+');
Route::post('/news/{id}', [NewsController::class, 'storeComment'])->middleware('auth')->where('id', '[0-9]+');
Route::get('/news/new', [NewsController::class, 'create'])->middleware('auth')->middleware('minimumAccess:Editor');
Route::post('/news/new', [NewsController::class, 'store'])->name('newArticle')->middleware('auth')->middleware('minimumAccess:Editor');
Route::get('news/edit/{id}', [NewsController::class, 'edit']);
Route::post('news/edit/{id}', [NewsController::class, 'update']);

Route::get('/wiki', [WikiController::class, 'index']);
Route::get('/wiki/{id}/v{vid}', [WikiController::class, 'show'])->where('id', '[0-9]+');
Route::get('/wiki/{id}', [WikiController::class, 'showVers'])->where('id', '[0-9]+');
Route::get('/wiki/new', [WikiController::class, 'create'])->middleware('auth');
Route::post('/wiki/new', [WikiController::class, 'store'])->middleware('auth')->name('newWiki');
Route::get('/wiki/edit/{id}', [WikiController::class, 'edit'])->where('id', '[0-9]+')->middleware('auth');
Route::post('/wiki/edit/{id}', [WikiController::class, 'update'])->where('id', '[0-9]+')->middleware('auth');
Route::get('/wiki/search', [WikiController::class, 'search'])->name('searchWiki');

Route::resource('user', UserController::class);

Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/settings/{id}', [UserController::class, 'edit'])->middleware('USpecific');
Route::post('/settings/{id}', [UserController::class, 'update'])->middleware('USpecific');
Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->middleware('USpecific');

Route::get('/testing', function(){
    return view('testing');
});

Route::redirect('/dashboard', '/');

require __DIR__.'/auth.php';
