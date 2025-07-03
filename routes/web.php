<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkerImportController;

use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\MealRecordController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('companies', CompanyController::class);
Route::resource('workers', WorkerController::class);
Route::resource('service-types', ServiceTypeController::class);


Route::get('meal-record', [MealRecordController::class, 'create'])->name('meal.create');
Route::post('meal-record', [MealRecordController::class, 'store'])->name('meal.store');

Route::get('workers/import', [WorkerImportController::class, 'form'])->name('workers.import.form');

Route::post('workers/import', [WorkerImportController::class, 'import'])->name('workers.import');

