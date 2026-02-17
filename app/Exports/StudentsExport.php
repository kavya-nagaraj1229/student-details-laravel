<?php
namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    protected $studentId;

    public function __construct($studentId = null)
    {
        $this->studentId = $studentId;
    }

    public function collection()
    {
        if($this->studentId){
            return Student::where('id', $this->studentId)->get();
        }
        return Student::all();
    }
}

