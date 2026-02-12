<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mpdf\Mpdf;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        if (session('role') === 'admin') {
            $students = Student::all();
        } else {
            $students = Student::where('id', session('student_id'))->get();
        }

        return view('students.index', compact('students'));
    }

    // new student create
    public function create()
    {
        if(session('role') !== 'admin'){
            return redirect()->route('students.index');
        }
        return view('students.create');
    }

    public function store(Request $request)
    {
        if(session('role') !== 'admin'){
            return redirect()->route('students.index');
        }

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:students',
            'age'=>'required|integer',
            'dob'=>'required|date'
        ]);

        $student = Student::create($request->all());

        // user table store in students data
        DB::table('users')->insert([
            'username'   => strtolower($student->name),
            'password'   => Hash::make('stud123'),       
            'role'       => 'student',
            'student_id' => $student->id
        ]);

        return redirect()->route('students.index')->with('success','Student added successfully');
    }

    // edit
    public function edit(Student $student)
    {
        if(session('role') !== 'admin'){
            return redirect()->route('students.index');
        }
        return view('students.edit', compact('student'));
    }

    // update
    public function update(Request $request, Student $student)
    {
        if(session('role') !== 'admin'){
            return redirect()->route('students.index');
        }

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:students,email,'.$student->id,
            'age'=>'required|integer',
            'dob'=>'required|date'
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success','Student updated successfully');
    }

    // edit
    public function destroy(Student $student)
    {
        if(session('role') !== 'admin'){
            return redirect()->route('students.index');
        }

        $student->delete();
        return redirect()->route('students.index')->with('success','Student deleted successfully');
    }

    // logout
    public function logout()
    {
        session()->forget(['user_id','role','student_id']);
        return redirect('/');
    }

    // login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Wrong password');
        }

        session()->put('user_id', $user->id);
        session()->put('role', $user->role);
        session()->put('student_id', $user->student_id);

        return redirect('/students');
    }

    // pdf
    public function exportPDF()
    {
        if(session('role') === 'admin'){
            $students = Student::all();
        } else {
            $students = Student::where('id', session('student_id'))->get();
        }

        $html = view('students.pdf', compact('students'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="students.pdf"');
    }

    // excel
    public function exportExcel()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
