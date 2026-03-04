<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('/login', [StudentController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/marktables', [StudentController::class, 'storeMarktable']);
    Route::post('/marktables/{id}', [StudentController::class, 'updateMarktable']);
    Route::delete('/marktables/{id}', [StudentController::class, 'deleteMarktable']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/marktables', [StudentController::class, 'getMarktables']);
});