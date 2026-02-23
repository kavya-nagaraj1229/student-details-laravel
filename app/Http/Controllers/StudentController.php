<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Mpdf\Mpdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $students = Student::all();
        } else {
            $students = Student::where('id', $user->student_id)->get();
        }

        return view('students.index', compact('students'));
    }


    public function create()
    {
        return view('students.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'fathername' => 'nullable|string|max:255',
            'mothername' => 'nullable|string|max:255',
            'gender' => 'nullable|string',
            'maritalstatus' => 'nullable|string',
            'spouse' => 'nullable|string|max:255',
            'bloodgroup' => 'nullable|string|max:10',
            'education' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'aadhar' => 'nullable|string|max:20',
            'pan' => 'nullable|string|max:20',
            'license' => 'nullable|string|max:50',
            'pf_number' => 'nullable|string|max:50',
            'uan_number' => 'nullable|string|max:50',
            'esi_number' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string',
            'contact_pincode' => 'nullable|string|max:10',
            'permanent_address' => 'nullable|string',
            'permanent_pincode' => 'nullable|string|max:10',
            'email' => 'required|email|unique:students,email',
            'age' => 'required|integer|min:1',
            'dob' => 'required|date',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',

        ]);
        $data = $request->only([
            'name',
            'lastname',
            'fathername',
            'mothername',
            'gender',
            'maritalstatus',
            'spouse',
            'bloodgroup',
            'education',
            'contact_number',
            'aadhar',
            'pan',
            'license',
            'pf_number',
            'uan_number',
            'esi_number',
            'contact_address',
            'contact_pincode',
            'permanent_address',
            'permanent_pincode',
            'email',
            'age',
            'dob'
        ]);

        if ($request->hasFile('files')) {
            $uploaded = [];
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/images'), $filename);
                $uploaded[] = $filename;
            }
            $data['files'] = json_encode($uploaded);
        }

        $student = Student::create($data);


        User::create([
            'username' => $request->name,
            'password' => Hash::make('student123'),
            'role' => 'student',
            'student_id' => $student->id,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'fathername' => $request->fathername,
            'mothername' => $request->mothername,
            'gender' => $request->gender,
            'maritalstatus' => $request->maritalstatus,
            'spouse' => $request->spouse,
            'bloodgroup' => $request->bloodgroup,
            'education' => $request->education,
            'contact_number' => $request->contact_number,
            'aadhar' => $request->aadhar,
            'pan' => $request->pan,
            'license' => $request->license,
            'pf_number' => $request->pf_number,
            'uan_number' => $request->uan_number,
            'esi_number' => $request->esi_number,
            'contact_address' => $request->contact_address,
            'contact_pincode' => $request->contact_pincode,
            'permanent_address' => $request->permanent_address,
            'permanent_pincode' => $request->permanent_pincode,
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully!');
    }



    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'age'   => 'required|integer|min:1',
            'dob'   => 'required|date'
        ]);

        $data = $request->only([
            'name',
            'lastname',
            'fathername',
            'mothername',
            'gender',
            'maritalstatus',
            'bloodgroup',
            'education',
            'contact_number',
            'aadhar',
            'pan',
            'contact_address',
            'contact_pincode',
            'permanent_address',
            'permanent_pincode',
            'email',
            'age',
            'dob'
        ]);

        if ($request->hasFile('files')) {

            $uploaded = [];

            foreach ($request->file('files') as $file) {

                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads/images'), $filename);

                $uploaded[] = $filename;
            }

            $existing = $student->files ? json_decode($student->files) : [];

            $data['files'] = json_encode(array_merge($existing, $uploaded));
        }

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        if ($student->files) {
            foreach (json_decode($student->files) as $file) {
                $path = public_path('uploads/images/' . $file);
                if (file_exists($path)) unlink($path);
            }
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }



    public function deleteFile(Student $student, $filename)
    {
        $files = $student->files ? json_decode($student->files, true) : [];
        $filename = urldecode($filename);

        if (($key = array_search($filename, $files)) !== false) {
            unset($files[$key]);
            $student->files = json_encode(array_values($files));
            $student->save();
            $filePath = public_path('uploads/images/' . $filename);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            return back();
        }

        return back()->with('error', 'File not found!');
    }


    public function downloadPdf()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $students = Student::all();
        $mpdf = new Mpdf();
        $html = view('students.pdf', compact('students'))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('students.pdf', 'D');
    }

    public function downloadExcel()
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        return Excel::download(new StudentsExport, 'students.xlsx');
    }


    public function myPdf()
    {
        if (Auth::user()->role != 'student') {
            abort(403);
        }

        $students = Student::where('name', Auth::user()->username)->get();

        $mpdf = new \Mpdf\Mpdf();
        $html = view('students.pdf', compact('students'))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('my_details.pdf', 'D');
    }


    public function myExcel()
    {
        if (Auth::user()->role != 'student') {
            abort(403);
        }

        $student = Student::where('name', Auth::user()->username)->get();

        return Excel::download(new StudentsExport($student), 'my_details.xlsx');
    }

    public function show($id)
{
    $student = Student::findOrFail($id);
    return view('students.show', compact('student'));
}
}
