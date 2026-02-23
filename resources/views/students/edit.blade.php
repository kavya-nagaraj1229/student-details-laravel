<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-lg">

<h1 class="text-2xl font-bold text-center mb-4">Edit Student</h1>

<a href="{{ route('students.index') }}" class="text-blue-600 block text-center mb-3">
← Back
</a>

@if(session('success'))
<p class="bg-green-100 text-green-700 p-2 mb-3 rounded">
{{ session('success') }}
</p>
@endif

<form action="{{ route('students.update', $student) }}" 
method="POST" 
enctype="multipart/form-data"
class="grid grid-cols-2 gap-4">

@csrf
@method('PUT')

<div>
<label class="font-bold">Name</label>
<input type="text" name="name" value="{{ $student->name }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Last Name</label>
<input type="text" name="lastname" value="{{ $student->lastname }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Email</label>
<input type="email" name="email" value="{{ $student->email }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Age</label>
<input type="number" name="age" value="{{ $student->age }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">DOB</label>
<input type="date" name="dob" value="{{ $student->dob }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Father Name</label>
<input type="text" name="fathername" value="{{ $student->fathername }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Mother Name</label>
<input type="text" name="mothername" value="{{ $student->mothername }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Gender</label>
<select name="gender" class="w-full border p-2 rounded">
<option value="Male" {{ $student->gender=='Male'?'selected':'' }}>Male</option>
<option value="Female" {{ $student->gender=='Female'?'selected':'' }}>Female</option>
</select>
</div>

<div>
<label class="font-bold">Marital Status</label>
<input type="text" name="maritalstatus" value="{{ $student->maritalstatus }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Spouse</label>
<input type="text" name="spouse" value="{{ $student->spouse }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Blood Group</label>
<input type="text" name="bloodgroup" value="{{ $student->bloodgroup }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Education</label>
<input type="text" name="education" value="{{ $student->education }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Contact Number</label>
<input type="text" name="contact_number" value="{{ $student->contact_number }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">Aadhar</label>
<input type="text" name="aadhar" value="{{ $student->aadhar }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">PAN</label>
<input type="text" name="pan" value="{{ $student->pan }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">License</label>
<input type="text" name="license" value="{{ $student->license }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">PF Number</label>
<input type="text" name="pf_number" value="{{ $student->pf_number }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">UAN Number</label>
<input type="text" name="uan_number" value="{{ $student->uan_number }}" class="w-full border p-2 rounded">
</div>

<div>
<label class="font-bold">ESI Number</label>
<input type="text" name="esi_number" value="{{ $student->esi_number }}" class="w-full border p-2 rounded">
</div>

<div class="col-span-2">
<label class="font-bold">Contact Address</label>
<textarea name="contact_address" class="w-full border p-2 rounded">{{ $student->contact_address }}</textarea>
</div>

<div>
<label class="font-bold">Pincode</label>
<input type="text" name="contact_pincode" value="{{ $student->contact_pincode }}" class="w-full border p-2 rounded">
</div>

<div class="col-span-2">
<label class="font-bold">Permanent Address</label>
<textarea name="permanent_address" class="w-full border p-2 rounded">{{ $student->permanent_address }}</textarea>
</div>

<div>
<label class="font-bold">Pincode</label>
<input type="text" name="permanent_pincode" value="{{ $student->permanent_pincode }}" class="w-full border p-2 rounded">
</div>

<div class="col-span-2">
<label class="font-bold">Upload Files</label>
<input type="file" name="files[]" multiple class="w-full border p-2 rounded">
</div>

<div class="col-span-2">
<button class="w-full bg-green-600 text-white py-2 rounded">
Update Student
</button>
</div>

</form>

@if($student->files)
<hr class="my-4">
<h3 class="font-bold mb-2">Uploaded Files</h3>

@foreach(json_decode($student->files) as $file)
@php $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); @endphp

<div class="flex justify-between items-center border p-2 rounded mb-1">

    <span 
        class="text-sm text-blue-600 cursor-pointer hover:underline"
        onclick="viewFile('{{ asset('uploads/images/'.$file) }}','{{ in_array($ext,['jpg','jpeg','png','gif']) ? 'img' : 'pdf' }}')">
        {{ $file }}
    </span>

    <form action="{{ route('students.files.delete', [$student, urlencode($file)]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button 
            onclick="return confirm('Delete this file?')" 
            class="text-red-600 font-bold text-xl">
            X
        </button>
    </form>

</div>
@endforeach
@endif

</div>

{{-- Modal for File Preview --}}
<div id="fileModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex justify-center items-center z-50">
    <div class="bg-white p-4 rounded relative max-w-[90vw] max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-red-600 font-bold text-3xl">X</button>
        <img id="modalImg" class="hidden max-h-[80vh] max-w-[80vw] rounded">
        <iframe id="modalPdf" class="hidden w-[80vw] h-[80vh] border"></iframe>
    </div>
</div>

<script>
function viewFile(src, type){
    const modal = document.getElementById('fileModal');
    const img = document.getElementById('modalImg');
    const pdf = document.getElementById('modalPdf');

    img.classList.add('hidden');
    pdf.classList.add('hidden');

    if(type == 'img'){
        img.src = src;
        img.classList.remove('hidden');
    } else if(type == 'pdf'){
        pdf.src = src;
        pdf.classList.remove('hidden');
    } else {
        alert('Preview not supported for this file type');
        return;
    }

    modal.classList.remove('hidden');
}

function closeModal(){
    const modal = document.getElementById('fileModal');
    modal.classList.add('hidden');
    document.getElementById('modalImg').src = '';
    document.getElementById('modalPdf').src = '';
}
</script>

</body>
</html>