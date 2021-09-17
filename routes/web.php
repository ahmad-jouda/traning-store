<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\UserController;
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

/*
Route::group([
    'prefix' => 'admin/categories',
    'namespace' => 'Admin',
    'as' => 'admin.categories.'
], function(){
    Route::resource('/', 'CategoriesController');

});
*/
Route::get('/dashboard',[DashboardController::class,'index']);

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

Route::get('admin/tags/{id}/products',[TagsController::class,'products']);

Route::get('admin/users/{id}',[UserController::class,'show'])->name('admin.users.show');

/* Regular Expressions 
    لبحث عن كلمة أو رقم معين
    ^ يبدأ بالرقم الي بعده
    $ ينتهي بالرقم الي قبله
    (\d{7})$ يكون بعد 059 سبع أرقام ولا يوجد بعد السبع ارقام شي
    (059|056) يبحث عن الرقم هاد أو هاد
    [0-9] الارقام تكون من 0 الي 9
    {1,7} اقل شيء يكون رقم واحد واكثر شيء يكون رقم 7
    \- يكون الرقم بينه وبين المقدمة سلاش
    \-? موجودة أو غير موجودة مو مشكلة
    [a-zA-Z0-9] ممكن يكون الارقام و أحرف كبيرة و أحرف صغيرة
    \s_\.  يكون مسافة بينهم أو أندر سكور أو نقطة لازم تحط باك سلاش

    Route::get('regexp', function(){
        $test = '059-7101386,059-9487421,059-9462733';
        $exp = '/^(059|056)\-?([0-9]{7})$/'; لرقم واحد
        $exp = '/(059|056)\-?([0-9]{7})/';

        $email = 'name.last-name_12@domain.com';
        $pattern = '/^[a-zA-Z0-9]+[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9]+[a-zA-Z0-9\.\-]*[a-zA-Z]+$/';

        preg_match($exp, $test, $matches); لرقم واحد
        preg_match_all($exp, $test, $matches); لعدة أرقام
        preg_match($pattern, $email, $matches);
        dd($matches);
    });
*/



