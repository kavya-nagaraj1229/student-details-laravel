<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
<h1 class="text-2xl font-bold text-center mb-4">Add Student</h1>

<a href="{{ route('students.index') }}"
   class="text-blue-600 hover:underline block text-center mb-4">
Back to Students
</a>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
<ul class="list-disc list-inside">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form action="{{ route('students.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="space-y-4">
@csrf

<div>
<label class="block text-sm font-medium">Name</label>
<input type="text" name="name"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Email</label>
<input type="email" name="email"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Age</label>
<input type="number" name="age"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">DOB</label>
<input type="date" name="dob"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Upload Files</label>
<input type="file" name="files[]" multiple
class="w-full border rounded px-3 py-2">

</div>

<button type="submit"
class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
Add Student
</button>

</form>
</div>

</body>
</html>