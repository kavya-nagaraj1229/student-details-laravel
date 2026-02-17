<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">

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
      class="space-y-3">
@csrf
@method('PUT')

<div>
<label class="block text-sm font-medium font-bold">Name</label>
<input type="text" name="name" value="{{ $student->name }}" class="w-full border p-2 rounded" required>
</div>

<div>
<label class="block text-sm font-medium font-bold">Email</label>
<input type="email" name="email" value="{{ $student->email }}" class="w-full border p-2 rounded" required>
</div>

<div>
<label class="block text-sm font-medium font-bold">Age</label>
<input type="number" name="age" value="{{ $student->age }}" class="w-full border p-2 rounded" required>
</div>

<div>
<label class="block text-sm font-medium font-bold">DOB</label>
<input type="date" name="dob" value="{{ $student->dob }}" class="w-full border p-2 rounded" required>
</div>

<div>
<label class="block font-semibold">Upload Files</label>
<input type="file" name="files[]" multiple class="w-full border p-2 rounded">
</div>

<button class="w-full bg-green-600 text-white py-2 rounded">
Update Student
</button>

</form>

@if($student->files)
<hr class="my-4">
<h3 class="font-bold mb-2">Uploaded Files</h3>

@foreach(json_decode($student->files) as $file)
<div class="flex justify-between items-center border p-2 rounded mb-1">

    <span class="text-sm">{{ $file }}</span>

<form action="{{ route('students.files.delete', [$student, urlencode($file)]) }}" method="POST" class="inline">

    @csrf
    @method('DELETE')
    <button type="submit" 
            onclick="return confirm('Are you sure you want to delete this file?')" 
            class="text-red-600 font-bold text-xl">
        X
    </button>
</form>

</div>
@endforeach
@endif

</div>
</body>
</html>
