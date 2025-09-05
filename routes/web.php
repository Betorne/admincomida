<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkerImportController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\MealRecordController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', fn() => view('dashboard'))
     ->middleware('auth')
     ->name('dashboard');

require __DIR__.'/auth.php';  // rutas de login/register/logout

Route::middleware('auth')->group(function () {

    
Route::resource('workers', WorkerController::class);
Route::resource('service-types', ServiceTypeController::class);

Route::resource('companies', CompanyController::class);
Route::get('companies/{company}/workers', [CompanyController::class, 'workers'])
     ->name('companies.workers');

Route::get('companies/{company}/workers/create', [CompanyController::class, 'createWorker'])
     ->name('companies.workers.create');
Route::post('companies/{company}/workers', [CompanyController::class, 'storeWorker'])
     ->name('companies.workers.store'); 
Route::get('companies/{company}/workers/{worker}/edit', [CompanyController::class, 'editWorker'])
     ->name('companies.workers.edit');
Route::patch('companies/{company}/workers/{worker}', [CompanyController::class, 'updateWorker'])
     ->name('companies.workers.update');
Route::delete('companies/{company}/workers/{worker}', [CompanyController::class, 'destroyWorker'])
     ->name('companies.workers.destroy');
     
Route::get('companies/{company}/workers/export/excel', [CompanyController::class, 'exportWorkersExcel'])
     ->name('companies.workers.export.excel');
Route::get('companies/{company}/workers/export/pdf',   [CompanyController::class, 'exportWorkersPdf'])
     ->name('companies.workers.export.pdf');

Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');       


Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/export/excel', [ReportController::class, 'exportExcel'])
     ->name('reports.export.excel');
Route::get('reports/export/pdf',   [ReportController::class, 'exportPdf'])
     ->name('reports.export.pdf');

     

Route::get('workers/import', [WorkerImportController::class, 'form'])->name('workers.import.form');

Route::post('workers/import', [WorkerImportController::class, 'import'])->name('workers.import');
    

});

Route::get('meal-record', [MealRecordController::class, 'create'])->name('meal.create');
Route::post('meal-record', [MealRecordController::class, 'store'])->name('meal.store');

