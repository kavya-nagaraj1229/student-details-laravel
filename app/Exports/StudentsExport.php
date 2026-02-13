<?php
namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        if(session('role')==='admin'){
            return Student::all();
        } else {
            return Student::where('id', session('student_id'))->get();
        }
    }

    public function headings(): array
    {
        return ['ID','Name','Email','Age','DOB'];
    }
}
