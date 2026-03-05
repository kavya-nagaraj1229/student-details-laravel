@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Details</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Logout
    </button>
</form>

<div class="max-w-4xl mx-auto bg-white shadow rounded p-6 mt-6">

<h2 class="text-2xl font-bold mb-6">Student Details</h2>

<div class="flex border-b mb-6">
    <a href="{{ route('students.show', ['student' => $student->id, 'tab' => 'personal']) }}"
       class="px-4 py-2 font-semibold {{ $activeTab=='personal' ? 'border-b-2 border-blue-600' : '' }}">
       Personal Details
    </a>
    <a href="{{ route('students.show', ['student' => $student->id, 'tab' => 'address']) }}"
       class="px-4 py-2 font-semibold {{ $activeTab=='address' ? 'border-b-2 border-blue-600' : '' }}">
       Address
    </a>
    <a href="{{ route('students.show', ['student' => $student->id, 'tab' => 'marks']) }}"
       class="px-4 py-2 font-semibold {{ $activeTab=='marks' ? 'border-b-2 border-blue-600' : '' }}">
       10th Marks
    </a>
</div>

@if($activeTab == 'personal')
<div class="grid grid-cols-2 gap-4">
    <div><span class="font-semibold">ID :</span> <span>{{ $student->id }}</span></div>
    <div><span class="font-semibold">Name :</span> <span>{{ $student->name }} {{ $student->lastname }}</span></div>
    <div><span class="font-semibold">Email :</span> <span>{{ $student->email }}</span></div>
    <div><span class="font-semibold">Age :</span> <span>{{ $student->age }}</span></div>
    <div><span class="font-semibold">DOB :</span> <span>{{ $student->dob }}</span></div>
    <div><span class="font-semibold">Father Name :</span> <span>{{ $student->fathername }}</span></div>
    <div><span class="font-semibold">Mother Name :</span> <span>{{ $student->mothername }}</span></div>
    <div><span class="font-semibold">Gender :</span> <span>{{ $student->gender }}</span></div>
    <div><span class="font-semibold">Marital Status :</span> <span>{{ $student->maritalstatus }}</span></div>
    <div><span class="font-semibold">Spouse :</span> <span>{{ $student->spouse }}</span></div>
    <div><span class="font-semibold">Blood Group :</span> <span>{{ $student->bloodgroup }}</span></div>
    <div><span class="font-semibold">Education :</span> <span>{{ $student->education }}</span></div>
    <div><span class="font-semibold">Contact Number :</span> <span>{{ $student->contact_number }}</span></div>
    <div><span class="font-semibold">Aadhar Number :</span> <span>{{ $student->aadhar }}</span></div>
    <div><span class="font-semibold">PAN Number :</span> <span>{{ $student->pan }}</span></div>
    <div><span class="font-semibold">License Number :</span> <span>{{ $student->license }}</span></div>
    <div><span class="font-semibold">PF Number :</span> <span>{{ $student->pf_number }}</span></div>
    <div><span class="font-semibold">UAN Number :</span> <span>{{ $student->uan_number }}</span></div>
    <div><span class="font-semibold">ESI Number :</span> <span>{{ $student->esi_number }}</span></div>
</div>
@endif

@if($activeTab == 'address')
<div class="grid grid-cols-2 gap-4">
    <div><span class="font-semibold">Contact Address :</span> <span>{{ $student->contact_address }}</span></div>
    <div><span class="font-semibold">Contact Pincode :</span> <span>{{ $student->contact_pincode }}</span></div>
    <div><span class="font-semibold">Permanent Address :</span> <span>{{ $student->permanent_address }}</span></div>
    <div><span class="font-semibold">Permanent Pincode :</span> <span>{{ $student->permanent_pincode }}</span></div>

    <div class="col-span-2">
        <span class="font-semibold">Uploaded Files :</span>
        <div class="mt-2 border p-3 rounded">
            @if($student->files)
                @foreach(json_decode($student->files) as $f)
                    @php $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION)); @endphp
                    <a href="{{ asset('uploads/images/'.$f) }}" target="_blank"
                       class="text-blue-600 cursor-pointer hover:underline">{{ $f }}</a>
                @endforeach
            @else
                <span class="text-gray-400">No files uploaded</span>
            @endif
        </div>
    </div>
</div>
@endif

@if($activeTab == 'marks')
<div class="grid grid-cols-2 gap-4">
    @php $marks = json_decode($student->marks,true); @endphp
    <div><span class="font-semibold">Tamil :</span> <span>{{ $marks['tamil'] ?? '-' }}</span></div>
    <div><span class="font-semibold">English :</span> <span>{{ $marks['english'] ?? '-' }}</span></div>
    <div><span class="font-semibold">Maths :</span> <span>{{ $marks['maths'] ?? '-' }}</span></div>
    <div><span class="font-semibold">Science :</span> <span>{{ $marks['science'] ?? '-' }}</span></div>
    <div><span class="font-semibold">Social :</span> <span>{{ $marks['social'] ?? '-' }}</span></div>
    <div><span class="font-semibold">Total :</span> <span>{{ $student->total ?? '-' }}</span></div>
    <div><span class="font-semibold">Average :</span> <span>{{ $student->average ?? '-' }}</span></div>
</div>
@endif

<div class="mt-6">
    <a href="{{ route('students.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Back to List
    </a>
</div>

</div>
</body>
</html>