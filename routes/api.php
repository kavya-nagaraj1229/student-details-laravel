<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('/marktables', [StudentController::class, 'storeMarktable']);
Route::put('/marktables/{id}', [StudentController::class, 'updateMarktable']);
Route::delete('/marktables/{id}', [StudentController::class, 'deleteMarktable']);