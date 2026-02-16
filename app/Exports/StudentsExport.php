<?php
namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    protected $id;

    public function __construct($id = null){
        $this->id = $id;
    }

    public function collection()
    {
        if($this->id){
            return Student::where('id',$this->id)->get();
        }
        return Student::all();
    }
}
