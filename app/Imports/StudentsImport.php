<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements 
    ToModel,
    WithHeadingRow
    {

    public function model(array $row)
    {

        $dob = null;
        $age = null;

        if (!empty($row['dob'])) {

            if (is_numeric($row['dob'])) {
                $dob = Date::excelToDateTimeObject($row['dob'])->format('Y-m-d');
            } else {
                $dob = Carbon::parse($row['dob'])->format('Y-m-d');
            }

            $age = Carbon::parse($dob)->diffInYears(Carbon::now());
        }

        $files = null;
        if (!empty($row['files'])) {
            $files = json_encode(explode(',', $row['files']));
        }

        $marks = [
            'tamil' => $row['tamil'] ?? 0,
            'english' => $row['english'] ?? 0,
            'maths' => $row['maths'] ?? 0,
            'science' => $row['science'] ?? 0,
            'social' => $row['social'] ?? 0,
        ];

        return new Student([

            'name' => $row['name'] ?? null,
            'lastname' => $row['lastname'] ?? null,
            'email' => $row['email'] ?? null,

            'dob' => $dob,
            'age' => $age,

            'fathername' => $row['fathername'] ?? null,
            'mothername' => $row['mothername'] ?? null,

            'gender' => $row['gender'] ?? null,
            'maritalstatus' => $row['maritalstatus'] ?? null,
            'spouse' => $row['spouse'] ?? null,

            'bloodgroup' => $row['bloodgroup'] ?? null,
            'education' => $row['education'] ?? null,

            'contact_number' => $row['contact_number'] ?? null,
            'aadhar' => $row['aadhar'] ?? null,
            'pan' => $row['pan'] ?? null,
            'license' => $row['license'] ?? null,

            'pf_number' => $row['pf_number'] ?? null,
            'uan_number' => $row['uan_number'] ?? null,
            'esi_number' => $row['esi_number'] ?? null,

            'contact_address' => $row['contact_address'] ?? null,
            'contact_pincode' => $row['contact_pincode'] ?? null,

            'permanent_address' => $row['permanent_address'] ?? null,
            'permanent_pincode' => $row['permanent_pincode'] ?? null,

            'files' => $files,
            'marks' => json_encode($marks)
        ]);
    }

}