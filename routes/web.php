<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\Category;

use App\Http\Controllers\ArticlesController;

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

Route::get('articles',[ArticlesController::class,'index']);

Route::get('articles/{article}',[ArticlesController::class,'show']);

Route::get('categories/{category:name}', function (Category $category) {

    return view('articles',['articles' => $category->articles()->paginate(2)]);
});

Route::get('register',[RegisterController::class,'create'])->middleware('guest');
Route::post('register',[RegisterController::class,'store']);
Route::get('logout',[SessionController::class,'destroy']);
