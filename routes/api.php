<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('/marktables', [StudentController::class, 'storeMarktable']);
Route::post('/marktables/{id}', [StudentController::class, 'updateMarktable']);
Route::delete('/marktables/{id}', [StudentController::class, 'deleteMarktable']);
Route::get('/marktables', [StudentController::class, 'getMarktables']);
