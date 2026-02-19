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
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'age'   => 'required|integer|min:1',
        'dob'   => 'required|date',
        'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048'
    ]);
    $data = $request->only(['name','email','age','dob']);
    if ($request->hasFile('files')) {
        $uploaded = [];
        foreach ($request->file('files') as $file) {
            $filename = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filename);
            $uploaded[] = $filename;
        }
        $data['files'] = json_encode($uploaded);
    }

     $student= Student::create($data);

  
    User::create([
        'username' => $request->email,
        'password' => Hash::make('student123'),
        'role' => 'student',
        'student_id'=> $student->id,
    ]);
  

    return redirect()->route('students.index')
                     ->with('success','Student added successfully!');
}

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'age'   => 'required|integer|min:1',
            'dob'   => 'required|date',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048'
        ]);

        $data = $request->only(['name','email','age','dob']);

        if ($request->hasFile('files')) {
            $uploaded = [];
            foreach ($request->file('files') as $file) {
                $filename = time().'_'.uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/images'), $filename);
                $uploaded[] = $filename;
            }
            $existing = $student->files ? json_decode($student->files) : [];
            $data['files'] = json_encode(array_merge($existing, $uploaded));
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        if($student->files){
            foreach(json_decode($student->files) as $file){
                $path = public_path('uploads/images/'.$file);
                if(file_exists($path)) unlink($path);
            }
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }



  public function deleteFile(Student $student, $filename)
{
    $files = $student->files ? json_decode($student->files, true) : [];
    $filename = urldecode($filename);

    if(($key = array_search($filename, $files)) !== false){
        unset($files[$key]);
        $student->files = json_encode(array_values($files));
        $student->save();
        $filePath = public_path('uploads/images/' . $filename);
        if(file_exists($filePath)){
            unlink($filePath);
        }

        return back();
    }

    return back()->with('error', 'File not found!');
}


public function downloadPdf()
{
    if(Auth::user()->role != 'admin'){
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
    if(Auth::user()->role != 'admin'){
        abort(403);
    }

    return Excel::download(new StudentsExport, 'students.xlsx');
}


public function myPdf()
{
    if(Auth::user()->role != 'student'){
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
    if(Auth::user()->role != 'student'){
        abort(403);
    }

    $student = Student::where('name', Auth::user()->username)->get();

    return Excel::download(new StudentsExport($student), 'my_details.xlsx');
}

}
