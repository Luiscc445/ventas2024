<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Denominations;
use App\Http\Livewire\Products;


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