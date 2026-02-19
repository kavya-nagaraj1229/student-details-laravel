<?php
namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;


   class StudentsExport implements FromCollection
{
    protected $students;

    public function __construct($students = null)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students ?? Student::all();
    }
}



