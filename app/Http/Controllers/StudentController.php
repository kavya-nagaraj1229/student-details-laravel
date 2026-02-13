<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mpdf\Mpdf;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    // all student list
    public function index()
    {
        if (session('role') === 'admin') {
            $students = Student::all();
        } else {
            $students = Student::where('id', session('student_id'))->get();
        }

        return view('students.index', compact('students'));
    }

    // add new student
    public function create()
    {
        if (session('role') !== 'admin') {
            return redirect()->route('students.index');
        }
        return view('students.create');
    }

    //store the student data
    public function store(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('students.index');
        }

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:students',
            'age'   => 'required|integer',
            'dob'   => 'required|date',
            'files.*' => 'mimes:jpg,png,pdf,docx|max:2048'
        ]);

        // Upload files
        $filesArr = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/images'), $name);
                $filesArr[] = $name;
            }
        }

        $student = Student::create([
            'name'  => $request->name,
            'email' => $request->email,
            'age'   => $request->age,
            'dob'   => $request->dob,
            'files' => json_encode($filesArr)
        ]);


        $username = strtolower($student->name);
        $existing = DB::table('users')->where('username', $username)->first();
        if (!$existing) {
            DB::table('users')->insert([
                'username'   => $username,
                'password'   => Hash::make('stud123'),
                'role'       => 'student',
                'student_id' => $student->id
            ]);
        }

        return redirect()->route('students.index');
    }

    //edit 
    public function edit(Student $student)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('students.index');
        }
        return view('students.edit', compact('student'));
    }

    // update
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'age'   => 'required|numeric',
            'dob'   => 'required|date',
            'files.*' => 'mimes:jpg,png,pdf,docx|max:2048'
        ]);

        $student->name  = $request->name;
        $student->email = $request->email;
        $student->age   = $request->age;
        $student->dob   = $request->dob;

        $oldFiles = $student->files ? json_decode($student->files, true) : [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/images'), $name);
                $oldFiles[] = $name;
            }
        }

        $student->files = json_encode($oldFiles);
        $student->save();

        return back();
    }

    // delete
    public function destroy(Student $student)
    {
        if (session('role') !== 'admin') {
            return redirect()->route('students.index');
        }

        if ($student->files) {
            foreach (json_decode($student->files, true) as $f) {
                $filePath = public_path('uploads/images/' . $f);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }

        $student->delete();

        return redirect()->route('students.index');
    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if (!isset($user->PASSWORD)) {
            return back()->with('error', 'Password not set for user');
        }

        if (!Hash::check($request->password, $user->PASSWORD)) {
            return back()->with('error', 'Wrong password');
        }

        session()->put('user_id', $user->id);
        session()->put('role', $user->ROLE);
        session()->put('student_id', $user->student_id);

        return redirect('/students');
    }

    // logout
    public function logout()
    {
        session()->forget(['user_id', 'role', 'student_id']);
        return redirect('/');
    }

    // pdf download
    public function exportStudentPDF($id)
    {
        $students = Student::where('id', $id)->get();

        $html = view('students.pdf', compact('students'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="student.pdf"');
    }

    //excel download
    public function exportStudentExcel($id)
    {
        return Excel::download(new StudentsExport($id), 'student.xlsx');
    }


    public function deleteFile(Request $request)
    {
        $student = Student::findOrFail($request->student_id);

        $files = json_decode($student->files, true);
        $files = array_values(array_diff($files, [$request->file]));

        $filePath = public_path('uploads/images/' . $request->file);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $student->files = json_encode($files);
        $student->save();

        return back();
    }
}
