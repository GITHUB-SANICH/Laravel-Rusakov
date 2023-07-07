<?php

use App\Http\Controllers\ProfileController;
use App\Models\Address;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/sendpayment', function(){
	return 'send payment';
})->middleware('password.confirm');

//самописные маршруты
Route::get('/profile_2', function(){
	return 'profile_2';
})->middleware('auth.basic');

Route::get('/createaddress', function(){
	return 'создание нового адреса разрешено';
})->middleware('can:create, App\Models\Address');

Route::get('/viewaddress/{address}', function(Address $address){
	return 'просмотр адреса доступен: '.$address->id;
})->middleware('can:view,address');

Route::resource('/addresses', App\Http\Controllers\AddressController::class);

require __DIR__.'/auth.php';
