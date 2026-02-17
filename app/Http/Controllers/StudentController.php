<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $students = Student::get();
            
      
          
           
        } else {
            $students = Student::where('id', $user->id)->get();
             
        }
     

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    
public function store(Request $request)
{
    // Validation
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'age'   => 'required|integer|min:1',
        'dob'   => 'required|date',
        'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:2048'
    ]);

    // Prepare data
    $data = $request->only(['name','email','age','dob']);
    
  

    // Handle files if uploaded
    if ($request->hasFile('files')) {
        $uploaded = [];
        foreach ($request->file('files') as $file) {
            $filename = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/images'), $filename);
            $uploaded[] = $filename;
        }
        $data['files'] = json_encode($uploaded);
    }

    // Create student
    Student::create($data);

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
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->email !== $student->email) {
            abort(403, 'Unauthorized');
        }

        $files = $student->files ? json_decode($student->files, true) : [];

        if (($key = array_search($filename, $files)) !== false) {
            unset($files[$key]);
            $path = public_path('uploads/images/'.$filename);
            if (file_exists($path)) unlink($path);
        }

        $student->files = json_encode(array_values($files));
        $student->save();

        return back()->with('success', 'File deleted successfully!');
    }

    // Admin PDF
    public function exportPdf()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403, 'Unauthorized');

        $students = Student::all();
        $html = view('students.pdf', compact('students'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('students.pdf', Destination::DOWNLOAD);
    }

    // Single student PDF
    public function studentPdf(Student $student)
    {
        $user = Auth::user();
        if ($user->role === 'student' && $user->id !== $student->id) abort(403, 'Unauthorized');

        $html = view('students.pdf', ['students'=>[$student]])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('student.pdf', Destination::DOWNLOAD);
    }

    public function exportExcel()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403, 'Unauthorized');

        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
