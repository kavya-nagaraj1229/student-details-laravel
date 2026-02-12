<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
 
Route::get('/', function () {
    return view('login');
});

Route::get('/', function(){ return view('login'); });
Route::post('/login',[StudentController::class,'login']);
Route::post('/logout',[StudentController::class,'logout']);

Route::get('/students/pdf',[StudentController::class,'exportPDF'])->name('students.pdf');
Route::get('/students/excel',[StudentController::class,'exportExcel'])->name('students.excel');

Route::resource('students', StudentController::class)->except(['show']);

