<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

//Route home page url
Route::get('/home', function () {
    return view('home');
});

//Route about page url
Route::get('/about', function () {
    return view('about');
});

//Route Contact us page
Route::get('/contact-seo-url-testing',[ContactController::class,'index'])->name('con');
// All Route Category page
Route::get('/category/all', [CategoryController::class, 'allcategory'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCategory'])->name('add.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'EditCategory']);
Route::post('/category/update/{id}', [CategoryController::class, 'UpdateCategory']);
Route::get('/Trash/category/{id}', [CategoryController::class, 'TrashCategory']);
Route::get('/restore/category/{id}', [CategoryController::class, 'RestoreCategory']);
Route::get('/Delete/category/{id}', [CategoryController::class, 'DeleteCategory']);
// End Category

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all();
   //$users = DB::table('users')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});
