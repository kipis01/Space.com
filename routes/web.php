<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;

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

Route::get('/news', function(){
    return view('Temp');
});

Route::get('/wiki', function(){
    return view('Temp');
});

Route::resource('forum', ForumController::class);
Route::get('/forum/{id}', [ForumController::class, 'show']);

Route::resource('user', UserController::class);
//Route::get('/authenticate/register', [UserController::class, 'create']);//TODO:Remove

//Route::get('/authenticate', [UserController::class, 'loginScreen']);//add a middleware for logged in users
//Route::post('authenticate', [UserController::class, 'login']);//TODO:Remove

Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/settings/{id}', [UserController::class, 'edit'])->middleware('USpecific');
Route::post('/settings/{id}', [UserController::class, 'update'])->middleware('USpecific');
Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->middleware('USpecific');

Route::get('/testing', function(){
    return view('testing');
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::redirect('/dashboard', '/');

require __DIR__.'/auth.php';
