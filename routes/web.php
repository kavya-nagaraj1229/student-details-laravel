<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

// Login & Logout
Route::get('/', function () { return view('login'); })->name('login.form');
Route::post('/login', [StudentController::class,'login'])->name('login');
Route::post('/logout', [StudentController::class,'logout'])->name('logout');

// Student resource routes
Route::resource('students', StudentController::class)->except(['show']);

// Upload / Delete files
Route::post('/students/{student}/files', [StudentController::class,'uploadFiles'])
    ->name('students.files.upload');
Route::post('/students/delete-file', [StudentController::class,'deleteFile'])
    ->name('students.files.delete');

// PDF Routes
Route::get('/students/pdf', [StudentController::class, 'exportPDF'])->name('students.pdf'); // all students
Route::get('/students/pdf/{id}', [StudentController::class,'exportStudentPDF'])->name('students.student.pdf'); // single student

// Excel Routes
Route::get('/students/excel', [StudentController::class,'exportExcel'])->name('students.excel'); // all students
Route::get('/students/excel/{id}', [StudentController::class,'exportStudentExcel'])->name('students.student.excel'); // single student
