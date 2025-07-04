<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkerImportController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\MealRecordController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('companies', CompanyController::class);
// Ruta para listar los trabajadores de una empresa
Route::get('companies/{company}/workers', [CompanyController::class, 'workers'])
     ->name('companies.workers');



Route::resource('workers', WorkerController::class);
Route::resource('service-types', ServiceTypeController::class);

Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/export/excel', [ReportController::class, 'exportExcel'])
     ->name('reports.export.excel');
Route::get('reports/export/pdf',   [ReportController::class, 'exportPdf'])
     ->name('reports.export.pdf');

     

Route::get('meal-record', [MealRecordController::class, 'create'])->name('meal.create');
Route::post('meal-record', [MealRecordController::class, 'store'])->name('meal.store');

Route::get('workers/import', [WorkerImportController::class, 'form'])->name('workers.import.form');

Route::post('workers/import', [WorkerImportController::class, 'import'])->name('workers.import');

