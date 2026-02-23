@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Details</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

{{-- Logout --}}
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
</form>

{{-- Student Details Card --}}
<div class="max-w-3xl mx-auto bg-white shadow rounded p-6 mt-6">

<h2 class="text-2xl font-bold mb-4">Student Personal Details</h2>

<div class="grid grid-cols-2 gap-4">

    <div>
        <span class="font-semibold">ID:</span>
        <span>{{ $student->id }}</span>
    </div>
    <div>
        <span class="font-semibold">Name:</span>
        <span>{{ $student->name }} {{ $student->lastname }}</span>
    </div>
    <div>
        <span class="font-semibold">Email:</span>
        <span>{{ $student->email }}</span>
    </div>
    <div>
        <span class="font-semibold">Age:</span>
        <span>{{ $student->age }}</span>
    </div>
    <div>
        <span class="font-semibold">DOB:</span>
        <span>{{ $student->dob }}</span>
    </div>
    <div>
        <span class="font-semibold">Father Name:</span>
        <span>{{ $student->fathername }}</span>
    </div>
    <div>
        <span class="font-semibold">Mother Name:</span>
        <span>{{ $student->mothername }}</span>
    </div>
    <div>
        <span class="font-semibold">Gender:</span>
        <span>{{ $student->gender }}</span>
    </div>
    <div>
        <span class="font-semibold">Marital Status:</span>
        <span>{{ $student->maritalstatus }}</span>
    </div>
    <div>
        <span class="font-semibold">Blood Group:</span>
        <span>{{ $student->bloodgroup }}</span>
    </div>
    <div>
        <span class="font-semibold">Education:</span>
        <span>{{ $student->education }}</span>
    </div>
    <div>
        <span class="font-semibold">Contact Number:</span>
        <span>{{ $student->contact_number }}</span>
    </div>
    <div>
        <span class="font-semibold">Contact Address:</span>
        <span>{{ $student->contact_address }}</span>
    </div>
    <div>
        <span class="font-semibold">Permanent Address:</span>
        <span>{{ $student->permanent_address }}</span>
    </div>

    {{-- Files --}}
    <div class="col-span-2">
        <span class="font-semibold">Files:</span>
        <div class="mt-1 border p-2 rounded">
            @if($student->files)
                @foreach(json_decode($student->files) as $f)
                    @php $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION)); @endphp
                    <div onclick="viewFile('{{ asset('uploads/images/'.$f) }}','{{ in_array($ext,['jpg','jpeg','png','gif']) ? 'img' : 'pdf' }}')"
                        class="text-blue-600 cursor-pointer hover:underline">
                        {{ $f }}
                    </div>
                @endforeach
            @else
                <span class="text-gray-400">No files</span>
            @endif
        </div>
    </div>

</div>

{{-- Back Button --}}
<div class="mt-6">
    <a href="{{ route('students.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to List</a>
</div>

</div>

{{-- Modal for Viewing Files --}}
<div id="imgModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex justify-center items-center z-50">
    <div class="bg-white p-4 rounded relative">
        <button onclick="closeImg()" class="absolute top-2 right-2 text-red-600 font-bold text-3xl">X</button>
        <img id="popupImg" class="hidden max-h-[80vh] max-w-[80vw] rounded">
        <iframe id="popupPdf" class="hidden w-[80vw] h-[80vh] border"></iframe>
    </div>
</div>

<script>
function viewFile(src, type){
    const img = document.getElementById('popupImg');
    const pdf = document.getElementById('popupPdf');

    img.classList.add('hidden');
    pdf.classList.add('hidden');

    if(type == 'img'){
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