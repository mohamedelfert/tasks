<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::any('/', [TaskController::class, 'index'])->name('tasks.index');
Route::resource('tasks', TaskController::class);
Route::get('finish/{id}', [TaskController::class, 'finish'])->name('finish');

Route::get('/{page}', function ($id) {
    if (view()->exists($id)) {
        return view($id);
    } else {
        return view('404');
    }
});
