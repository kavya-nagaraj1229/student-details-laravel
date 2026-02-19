@php use Illuminate\Support\Facades\Auth; @endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Students List</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6 relative">

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Logout
    </button>
</form>

<div class="flex justify-between mb-6">
    <h2 class="text-2xl font-bold">Student List</h2>
<div class="space-x-2">
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('students.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">+ Add Student</a>

        <a href="{{ route('students.pdf') }}" 
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Download PDF</a>

        <a href="{{ route('students.excel') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Download Excel</a>
    @endif
</div>

</div>

{{-- Success message --}}
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif

<table class="w-full border text-sm bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Age</th>
            <th class="p-2 border">DOB</th>
            <th class="p-2 border">Files</th>
            @if(Auth::user()->role == 'admin')
           <th class="p-2 border">Actions</th>
           @endif
           @if(Auth::user()->role == 'student')
           <th class="p-2 border">PDF & EXCEL</th>
           @endif

        </tr>
    </thead>



    <tbody>
    @forelse($students as $student)
    <tr class="hover:bg-gray-50">

        <td class="p-2 border text-center">{{ $student->id }}</td>
        <td class="p-2 border">{{ $student->name }}</td>
        <td class="p-2 border">{{ $student->email }}</td>
        <td class="p-2 border text-center">{{ $student->age }}</td>
        <td class="p-2 border text-center">{{ $student->dob }}</td>

        {{-- Files --}}
        <td class="p-2 border text-sm">
            @if($student->files)
                @foreach(json_decode($student->files) as $f)
                    @php $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION)); @endphp
                    <span onclick="viewFile('{{ asset('uploads/images/'.$f) }}',
                        '{{ in_array($ext,['jpg','jpeg','png','gif']) ? 'img' : 'pdf' }}')"
                        class="text-blue-600 cursor-pointer block hover:underline">
                        {{ $f }}
                    </span>
                @endforeach
            @else
                <span class="text-gray-400">No files</span>
            @endif
        </td>

        {{-- Student Actions --}}
     @if(Auth::user()->role == 'student')
<td class="p-2 border">
    <div class="flex justify-center gap-2">
        <a href="{{ route('students.my.pdf') }}"
           class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
           My PDF
        </a>

        <a href="{{ route('students.my.excel') }}"
           class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
           My Excel
        </a>
    </div>
</td>
@endif


        {{-- Admin Actions --}}
        @if(Auth::user()->role == 'admin')
        <td class="p-2 border">
            <div class="flex justify-center gap-2">
                <a href="{{ route('students.edit', $student) }}"
                   class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 transition">
                   Edit
                </a>

                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </td>
        @endif

    </tr>
    @empty
    <tr>
        <td colspan="8" class="text-center text-red-600 py-4">No students found</td>
    </tr>
    @endforelse
    </tbody>
</table>

     

{{-- Modal for Files --}}
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
