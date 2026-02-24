<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentsExportBlade implements FromView
{
    protected $students;

    public function __construct($students = null)
    {
        $this->students = $students;
    }

    public function view(): View
    {
        $students = $this->students ?? Student::all();
        return view('students.excel', compact('students'));
    }
}