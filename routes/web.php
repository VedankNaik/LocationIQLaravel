<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServerController;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/forwardgeocode', [Controller::class, 'addressindex'])->middleware(['auth']);
Route::get('/forwardvalidate', [Controller::class, 'forwardvalidate'])->middleware(['auth']);
Route::get('/forwardvalidated', [Controller::class, 'forwardvalidated'])->middleware(['auth']);
Route::get('/reversegeocode', [Controller::class, 'reverseindex'])->middleware(['auth']);
Route::get('/reversevalidate', [Controller::class, 'reversevalidate'])->middleware(['auth']);
Route::get('/reversevalidated', [Controller::class, 'reversevalidated'])->middleware(['auth']);

// Route::get('/database', [ServerController::class, 'index']);
// Route::get('/disconnect', [ServerController::class, 'disconnect']);
// Route::POST('/testconnection', [ServerController::class, 'testconnection']);
// Route::POST('/executequery', [ServerController::class, 'executequery']);

// Route::get('/serverdashboard', function () {
//     return view('server.dashboard');
// });
Route::get('/maps', [ServerController::class, 'maps']);

Route::get('/serverdashboard', [ServerController::class, 'index']);
Route::get('/serverforwardgeocode', [ServerController::class, 'forwardindex']);
Route::POST('/serverforwardvalidate', [ServerController::class, 'forwardvalidate']);
Route::get('/serverforwardvalidated', [ServerController::class, 'forwardvalidated']);
Route::get('/serverreversegeocode', [ServerController::class, 'reverseindex']);
Route::POST('/serverreversevalidate', [ServerController::class, 'reversevalidate']);
Route::get('/serverreversevalidated', [ServerController::class, 'reversevalidated']);

Route::get('/database', [ServerController::class, 'index']);
Route::get('/disconnect', [ServerController::class, 'disconnect']);
Route::POST('/testconnection', [ServerController::class, 'testconnection']);
Route::POST('/winconnection', [ServerController::class, 'winconnection']);
Route::POST('/forwardquery', [ServerController::class, 'forwardquery']);
Route::POST('/reversequery', [ServerController::class, 'reversequery']);

require __DIR__.'/auth.php';
