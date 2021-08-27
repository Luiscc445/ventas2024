<?php

use App\Http\Livewire\Asignar;
use App\Http\Livewire\Cashout;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Denominations;
use App\Http\Livewire\Permiso;
use App\Http\Livewire\Pos;
use App\Http\Livewire\Products;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/category', function () {
    return view('category.index');
});

Route::get('categories', Categories::class);
Route::get('products', Products::class);
Route::get('denominations', Denominations::class);
Route::get('pos', Pos::class);
Route::get('roles', Roles::class);
Route::get('permission', Permiso::class);
Route::get('asignar', Asignar::class);
Route::get('users', Users::class);
Route::get('cashout', Cashout::class);