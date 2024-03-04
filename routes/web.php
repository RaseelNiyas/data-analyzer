<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FilterController;
use App\Models\Filter;



Route::post('/store-dynamic-data', 'DataController@storeDynamicData')->name('data.storeDynamicData');

// Route::post('/save-to-database', [DataController::class, 'storeDynamicData'])->name('save.to.database');
Route::post('/upload', [DataController::class, 'upload'])->name('upload.process');

Route::get('/filter/create', [FilterController::class, 'create'])->name('filter.create');
Route::post('/filter/store', [FilterController::class, 'store'])->name('filter.store');

Route::post('/upload', function () {
    // Change 'created' to 'create' in the following line
    Filter::create([
        'filter_name' => request('filter_name'),
        'filter_type' => request('filter_type'),
    ]);
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DataController::class, 'dashboard'])->name('dashboard');

    // Upload
    Route::get('/upload', [DataController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/upload', [DataController::class, 'upload'])->name('upload.process');

    // Download
    Route::get('/download', [DataController::class, 'download'])->name('download');

    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Default Laravel routes
Route::get('/', function () {
    return view('home');
});

Auth::routes();
