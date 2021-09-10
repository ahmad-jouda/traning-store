<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\DashboardController;
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

/*
Route::get('/dashboard','DashboardController@index');
Route::get('/dashboard',['DashboardController','index']);
*/

/*
Route::group([
    'prefix' => 'admin/categories',
    'as' => 'admin.categories.'

], function(){
    Route::get('/',[CategoriesController::class,'index'])->name('index');
    Route::get('/create',[CategoriesController::class,'create'])->name('create');
    Route::post('/create',[CategoriesController::class,'store'])->name('store');
    Route::get('/{id}',[CategoriesController::class,'show'])->name('show');
    Route::get('/{id}/edit',[CategoriesController::class,'edit'])->name('edit');
    Route::put('/{id}',[CategoriesController::class,'update'])->name('update');
    Route::delete('/{id}',[CategoriesController::class,'destroy'])->name('destroy');
});
*/

/*
Route::prefix('admin/categories')
        ->as('admin.categories.')
        ->group(function(){
            Route::get('/',[CategoriesController::class,'index'])->name('index');
            Route::get('/create',[CategoriesController::class,'create'])->name('create');
            Route::post('/create',[CategoriesController::class,'store'])->name('store');
            Route::get('/{id}/edit',[CategoriesController::class,'edit'])->name('edit');
            Route::put('/{id}',[CategoriesController::class,'update'])->name('update');
            Route::delete('/{id}',[CategoriesController::class,'destroy'])->name('destroy');
        });
*/

Route::get('/dashboard',[DashboardController::class,'index']);

Route::group([
    'prefix' => 'admin/categories',
    'namespace' => 'Admin',
], function(){
    Route::resource('', 'CategoriesController');

});



