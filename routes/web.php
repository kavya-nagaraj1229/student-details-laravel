<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect('/login');
});


// Login routes
Route::get('/login', [AuthController::class,'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class,'login'])->name('login.submit');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


Route::middleware('auth')->group(function(){

    Route::get('/students', [StudentController::class,'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class,'create'])->name('students.create');
    Route::post('/students', [StudentController::class,'store'])->name('students.store');

    Route::get('/students/{student}/edit', [StudentController::class,'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class,'update'])->name('students.update');

    Route::delete('/students/{student}/files/{filename}', [StudentController::class, 'deleteFile'])
     ->name('students.files.delete');


    Route::delete('/students/{student}', [StudentController::class,'destroy'])->name('students.destroy');
   
    
    Route::get('/students/pdf', [StudentController::class,'downloadPdf'])->name('students.pdf');
    Route::get('/students/excel', [StudentController::class,'downloadExcel'])->name('students.excel');


Route::get('/my/pdf', [StudentController::class,'myPdf'])->name('students.my.pdf');
Route::get('/my/excel', [StudentController::class,'myExcel'])->name('students.my.excel');


    
});
