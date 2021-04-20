<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForumController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/news');

Route::get('/news', function(){
    return view('Temp');
});

Route::get('/wiki', function(){
    return view('Temp');
});

Route::resource('forum', ForumController::class);
Route::get('/forum/{id}', [ForumController::class, 'show']);
