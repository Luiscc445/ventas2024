<?php

use App\Http\Controllers\ExportController;
use App\Http\Livewire\Asignar;
use App\Http\Livewire\Cashout;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Denominations;
use App\Http\Livewire\Permiso;
use App\Http\Livewire\Pos;
use App\Http\Livewire\Products;
use App\Http\Livewire\Reports;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/panel', function () {
    return view('panel');
})->name('panel');

Route::middleware(['auth'])->group(function () {

    Route::get('categories', Categories::class);
    Route::get('products', Products::class);
    Route::get('denominations', Denominations::class);
    Route::get('pos', Pos::class);

    Route::get('roles', Roles::class);
    Route::get('permission', Permiso::class);
    Route::get('asignar', Asignar::class);

    Route::get('users', Users::class);
    Route::get('cashout', Cashout::class);
    Route::get('reports', Reports::class);


    //Reportes PDF
    Route::get('report/pdf/{userid}/{type}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{userid}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);

    //Reportes Excel
    Route::get('report/excel/{userid}/{type}', [ExportController::class, 'reportExcel']);
    Route::get('report/excel/{userid}/{type}/{f1}/{f2}', [ExportController::class, 'reportExcel']);

});