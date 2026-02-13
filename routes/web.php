<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
 
Route::get('/', function () {
    return view('login');
});

Route::get('/', function(){ return view('login'); });
Route::post('/login',[StudentController::class,'login']);
Route::post('/logout',[StudentController::class,'logout']);

Route::get('/students/pdf', [StudentController::class,'exportPDF'])
    ->name('students.pdf');  

Route::get('/students/pdf/{id}', [StudentController::class,'exportStudentPDF'])
    ->name('students.student.pdf'); 


    Route::get('/students/excel', [StudentController::class,'exportExcel'])
    ->name('students.excel');

Route::get('/students/excel/{id}', [StudentController::class,'exportStudentExcel'])
    ->name('students.student.excel');


Route::resource('students', StudentController::class)->except(['show']);
Route::post('/students/{student}/files', [StudentController::class,'uploadFiles'])->name('students.files.upload/images');
Route::post('/students/delete-file',
[StudentController::class,'deleteFile'])
->name('students.files.delete');

;

