<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\user_control;
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

Route::get('/', function () {
    $news = ["مكافحه الارهاب", "مكافحه الارهاب", "مكافحه الارهاب"];
    return view('layouts/site/pages/home',  ['news' => $news]);
});

Route::get('/news-page', function () {
    return view('layouts/site/pages/news');
})->name('news');

Auth::routes();

Route::group(['middleware' => 'role:admin'], function () {

    Route::get(
        '/admin',
        [HomeController::class, 'index']
    )->name('admin');

    Route::resource('user-control', user_control::class);
    Route::resource('roles', RolesController::class);
});
