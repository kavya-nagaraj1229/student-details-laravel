<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Students List</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

<form method="POST" action="/logout" class="absolute top-4 right-4">
@csrf
<button class="bg-red-600 text-white px-4 py-2 rounded">Logout</button>
</form>

<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">

<div class="flex justify-between mb-4">
<h1 class="text-2xl font-bold">Students</h1>

@if(session('role')==='admin')
<div class="space-x-3">
<a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Student</a>
<a href="{{ route('students.pdf') }}" class="bg-red-600 text-white px-4 py-2 rounded">PDF</a>
<a href="{{ route('students.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded">Excel</a>
</div>
@endif
</div>

<table class="w-full border text-sm">
<thead class="bg-gray-200">
<tr>
<th class="p-2 border">ID</th>
<th class="p-2 border">Name</th>
<th class="p-2 border">Email</th>
<th class="p-2 border">Age</th>
<th class="p-2 border">DOB</th>
<th class="p-2 border">Files</th>

@if(session('role')==='admin')
<th class="p-2 border">Actions</th>
@endif

@if(session('role')==='student')
<th class="p-2 border">PDF</th>
<th class="p-2 border">Excel</th>
@endif
</tr>
</thead>

<tbody>
@foreach($students as $student)
<tr class="hover:bg-gray-50">
<td class="p-2 border">{{ $student->id }}</td>
<td class="p-2 border">{{ $student->NAME }}</td>
<td class="p-2 border">{{ $student->email }}</td>
<td class="p-2 border">{{ $student->age }}</td>
<td class="p-2 border">{{ $student->dob }}</td>

<td class="p-2 border text-sm">
@if($student->files)
@foreach(json_decode($student->files) as $f)
@php $ext = pathinfo($f, PATHINFO_EXTENSION); @endphp

@if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
<span onclick="viewFile('{{ asset('uploads/images/'.$f) }}','img')"
      class="text-blue-600 cursor-pointer block">
    {{ $f }}
</span>
@else
<span onclick="viewFile('{{ asset('uploads/images/'.$f) }}','pdf')"
      class="text-blue-600 cursor-pointer block">
    {{ $f }}
</span>
@endif

@endforeach
@else
<span class="text-gray-400">No files</span>
@endif
</td>

@if(session('role')==='admin')
<td class="p-2 border space-x-2">
<a href="{{ route('students.edit',$student) }}"
   class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>

<form action="{{ route('students.destroy',$student) }}"
      method="POST" class="inline">
@csrf
@method('DELETE')
<button class="bg-red-600 text-white px-2 py-1 rounded"
onclick="return">
Delete
</button>
</form>
</td>
@endif

@if(session('role')==='student')
<td class="p-2 border text-center">
<a href="{{ route('students.student.pdf',$student->id) }}"
   class="bg-red-600 text-white px-2 py-1 rounded text-xs">PDF</a>

</td>

<td class="p-2 border text-center">
<a href="{{ route('students.student.excel',$student->id) }}"
   class="bg-green-600 text-white px-2 py-1 rounded text-xs">Excel</a>
</td>
@endif

</tr>
@endforeach
</tbody>
</table>
</div>

<div id="imgModal"
class="fixed inset-0 bg-black bg-opacity-70 hidden flex justify-center items-center z-50">
<div class="bg-white p-4 rounded relative">
<button onclick="closeImg()"
class="absolute top-2 right-2 text-red-600 font-bold text-3xl" >X</button>

<img id="popupImg" class="hidden max-h-[80vh] max-w-[80vw] rounded">

<iframe id="popupPdf"
class="hidden w-[80vw] h-[80vh] border"></iframe>
</div>
</div>

<script>
function viewFile(src, type){
    const img = document.getElementById('popupImg');
    const pdf = document.getElementById('popupPdf');
    img.classList.add('hidden');
    pdf.classList.add('hidden');

    if(type === 'img'){
        img.src = src;
        img.classList.remove('hidden');
    } else {
        pdf.src = src;
        pdf.classList.remove('hidden');
    }
    document.getElementById('imgModal').classList.remove('hidden');
}

function closeImg(){
    document.getElementById('popupImg').src = '';
    document.getElementById('popupPdf').src = '';
    document.getElementById('imgModal').classList.add('hidden');
}
</script>

</body>
</html>
