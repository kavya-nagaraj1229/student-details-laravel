<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="bg-white w-full max-w-5xl p-8 rounded-lg shadow-lg">

<h1 class="text-2xl font-bold text-center mb-6">Add Student</h1>

<a href="{{ route('students.index') }}"
class="text-blue-600 hover:underline block text-center mb-6">
Back to Students
</a>

<div class="flex flex-col items-center mb-6">

<label class="block text-sm font-medium mb-2">Profile Photo</label>

<img id="preview"
src="https://via.placeholder.com/120"
class="w-28 h-28 rounded-full border object-cover mb-3">

<label class="cursor-pointer bg-gray-600 text-white px-1 py-1 rounded hover:bg-gray-700">

<span id="imgText">Add Image</span>

<input type="file"
name="profile"
accept="image/*"
onchange="previewImage(event)"
class="hidden">

</label>

</div>

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
enctype="multipart/form-data">

@csrf

<div class="grid grid-cols-2 gap-4">

<div>
<label class="block text-sm font-medium">First Name<span class="text-red-600">*</span></label>
<input type="text" name="name" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Last Name</label>
<input type="text" name="lastname" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Personnal Email<span class="text-red-600">*</span></label>
<input type="email" name="email" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Contact Number</label>
<input type="text" name="contact_number" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Age</label>
<input type="number" name="age" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">DOB<span class="text-red-600">*</span></label>
<input type="date" name="dob" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Father Name <span class="text-red-600">*</span></label>
<input type="text" 
       name="fathername" 
       class="w-full border rounded px-3 py-2" 
       required>
</div>
<div>
<label class="block text-sm font-medium">Mother Name</label>
<input type="text" name="mothername" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Gender<span class="text-red-600">*</span></label>
<select name="gender" class="w-full border rounded px-3 py-2">
<option value="">Select</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>

<div>
<label class="block text-sm font-medium">Marital Status<span class="text-red-600">*</span></label>
<select name="maritalstatus" class="w-full border rounded px-3 py-2">
<option value="">Select</option>
<option>Single</option>
<option>Married</option>
</select>
</div>

<div>
<label class="block text-sm font-medium">Spouse<span class="text-red-600">*</span></label>
<input type="text" name="spouse" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Blood Group<span class="text-red-600">*</span></label>
<input type="text" name="bloodgroup" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Education<span class="text-red-600">*</span></label>
<input type="text" name="education" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Aadhar<span class="text-red-600">*</span></label>
<input type="text" name="aadhar" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">PAN<span class="text-red-600">*</span></label>
<input type="text" name="pan" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">License</label>
<input type="text" name="license" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">PF Number</label>
<input type="text" name="pf_number" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">UAN Number</label>
<input type="text" name="uan_number" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">ESI Number</label>
<input type="text" name="esi_number" class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium">Contact Address</label>
<textarea name="contact_address" id="contact_address" class="w-full border rounded px-3 py-2"></textarea>
<label>
<input type="checkbox" id="same_address" onclick="copyAddress()"> Same as Contact Address
</label>
</div>

<div>
<label class="block text-sm font-medium">Pincode</label>
<input type="text" name="contact_pincode" id="contact_pincode" class="w-full border rounded px-3 py-2">
</div>


<div class="mt-3">
<label class="block text-sm font-medium">Permanent Address</label>
<textarea name="permanent_address" id="permanent_address" class="w-full border rounded px-3 py-2"></textarea>
</div>

<div>
<label class="block text-sm font-medium">Pincode</label>
<input type="text" name="permanent_pincode" id="permanent_pincode" class="w-full border rounded px-3 py-2">
</div>

<div class="col-span-2">
<label class="block text-sm font-medium">Upload Files</label>
<input type="file" name="files[]" multiple class="w-full border rounded px-3 py-2">
</div>

</div>

<button type="submit"
class="w-full mt-6 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
Add Student
</button>

</form>
</div>

</body>
</html>

<script>

function previewImage(event){

const reader = new FileReader();

reader.onload = function(){

document.getElementById('preview').src = reader.result;

document.getElementById('imgText').innerText = "Change Image";

}

reader.readAsDataURL(event.target.files[0]);

}

</script>
<script>
function copyAddress() {

let checkbox = document.getElementById("same_address");

if(checkbox.checked){

document.getElementById("permanent_address").value =
document.getElementById("contact_address").value;

document.getElementById("permanent_pincode").value =
document.getElementById("contact_pincode").value;

}else{

document.getElementById("permanent_address").value = "";
document.getElementById("permanent_pincode").value = "";

}

}
</script>