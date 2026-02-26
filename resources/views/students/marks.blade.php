<!DOCTYPE html>
<html>

<head>

<title>Student Marks</title>
<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="bg-white p-6 rounded shadow w-96">

<h2 class="text-xl font-bold mb-4">
Add Marks - {{ $student->name }}
</h2>

<form method="POST" action="{{ route('students.marks.store',$student->id) }}">

@csrf

<label>Tamil</label>
<input type="number" name="tamil" class="border w-full p-2 mb-2" required>

<label>English</label>
<input type="number" name="english" class="border w-full p-2 mb-2" required>

<label>Maths</label>
<input type="number" name="maths" class="border w-full p-2 mb-2" required>

<label>Science</label>
<input type="number" name="science" class="border w-full p-2 mb-2" required>

<label>Social</label>
<input type="number" name="social" class="border w-full p-2 mb-4" required>

<button class="bg-green-600 text-white px-4 py-2 rounded w-full">

Save Marks

</button>

</form>

</div>

</body>
</html>