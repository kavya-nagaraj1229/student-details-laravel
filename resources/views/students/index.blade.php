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
        @if (Auth::user()->role == 'admin')
            <h2 class="text-2xl font-bold">Admin - Student List</h2>
        @else
            <h2 class="text-2xl font-bold">Student - My Details</h2>
        @endif
        <div class="space-x-2">
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('students.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">+ Add Student</a>

                <a href="{{ route('students.pdf') }}"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Download PDF</a>

                <a href="{{ route('students.excel') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Download Excel</a>
                    
            @endif
        </div>

    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif


    @if (Auth::user()->role == 'admin')

        <table class="w-full border text-sm bg-white shadow rounded">
            <thead class="bg-gray-200">

                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">First Name</th>
                    <th class="p-2 border">Last Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Age</th>
                    <th class="p-2 border">DOB</th>
                    <th class="p-2 border">Father</th>
                    <th class="p-2 border">Mother</th>
                    <th class="p-2 border">Gender</th>
                    <th class="p-2 border">Marital</th>
                    <th class="p-2 border">Blood</th>
                    <th class="p-2 border">Education</th>
                    <th class="p-2 border">Contact</th>
                    <th class="p-2 border">Aadhar</th>
                    <th class="p-2 border">PAN</th>
                    <th class="p-2 border">License</th>
                    <th class="p-2 border">PF</th>
                    <th class="p-2 border">UAN</th>
                    <th class="p-2 border">ESI</th>
                    <th class="p-2 border">Contect Address</th>
                    <th class="p-2 border">Pincode</th>
                    <th class="p-2 border">Permanent Address</th>
                    <th class="p-2 border">Pincode</th>
                    <th class="p-2 border">Files</th>
                    <th class="p-2 border">Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse($students as $student)
                    <tr class="hover:bg-gray-50">

                        <td class="p-2 border text-center">{{ $student->id }}</td>

                        <td class="p-2 border">{{ $student->name }}</td>

                        <td class="p-2 border">{{ $student->lastname }}</td>

                        <td class="p-2 border">{{ $student->email }}</td>

                        <td class="p-2 border text-center">{{ $student->age }}</td>

                        <td class="p-2 border text-center">{{ $student->dob }}</td>

                        <td class="p-2 border">{{ $student->fathername }}</td>

                        <td class="p-2 border">{{ $student->mothername }}</td>

                        <td class="p-2 border">{{ $student->gender }}</td>

                        <td class="p-2 border">{{ $student->maritalstatus }}</td>

                        <td class="p-2 border">{{ $student->bloodgroup }}</td>

                        <td class="p-2 border">{{ $student->education }}</td>

                        <td class="p-2 border">{{ $student->contact_number }}</td>

                        <td class="p-2 border">{{ $student->aadhar }}</td>

                        <td class="p-2 border">{{ $student->pan }}</td>

                        <td class="p-2 border">{{ $student->license }}</td>

                        <td class="p-2 border">{{ $student->pf_number }}</td>

                        <td class="p-2 border">{{ $student->uan_number }}</td>

                        <td class="p-2 border">{{ $student->esi_number }}</td>

                        <td class="p-2 border">{{ $student->contact_address }}</td>

                        <td class="p-2 border">{{ $student->contact_pincode }}</td>

                        <td class="p-2 border">{{ $student->permanent_address }}</td>

                        <td class="p-2 border">{{ $student->permanent_pincode }}</td>

                        <td class="p-2 border text-sm">

                            @if ($student->files)
                                @foreach (json_decode($student->files) as $f)
                                    @php $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION)); @endphp

                                    <span
                                        onclick="viewFile('{{ asset('uploads/images/' . $f) }}',
'{{ in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) ? 'img' : 'pdf' }}')"
                                        class="text-blue-600 cursor-pointer block hover:underline">

                                        {{ $f }}

                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400">No files</span>
                            @endif

                        </td>

                        <td class="p-2 border">

                            <div class="flex justify-center gap-2">
                                <a href="{{ route('students.show', $student) }}"
                                    class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                                    View
                                </a>

                                <a href="{{ route('students.edit', $student) }}"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">

                                    Edit

                                </a>

                                <form action="{{ route('students.destroy', $student) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="22" class="text-center text-red-600 py-4">

                            No students found

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    @endif



    @if (Auth::user()->role == 'student')

        @forelse($students as $student)
            <div class="max-w-2xl mx-auto bg-white shadow rounded p-6 mb-4">

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="font-semibold">ID</label>
                        <p class="border p-2 rounded">{{ $student->id }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Name</label>
                        <p class="border p-2 rounded">{{ $student->name }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Email</label>
                        <p class="border p-2 rounded">{{ $student->email }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Age</label>
                        <p class="border p-2 rounded">{{ $student->age }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">DOB</label>
                        <p class="border p-2 rounded">{{ $student->dob }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Files</label>

                        @if ($student->files)
                            @foreach (json_decode($student->files) as $f)
                                @php $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION)); @endphp

                                <div onclick="viewFile('{{ asset('uploads/images/' . $f) }}',
        '{{ in_array($ext, ['jpg', 'jpeg', 'png', 'gif']) ? 'img' : 'pdf' }}')"
                                    class="text-blue-600 cursor-pointer hover:underline">

                                    {{ $f }}

                                </div>
                            @endforeach
                        @else
                            <span class="text-gray-400">No files</span>
                        @endif

                    </div>
                    <div>
                        <label class="font-semibold">Last Name</label>
                        <p class="border p-2 rounded">{{ $student->lastname }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Father Name</label>
                        <p class="border p-2 rounded">{{ $student->fathername }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Mother Name</label>
                        <p class="border p-2 rounded">{{ $student->mothername }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Gender</label>
                        <p class="border p-2 rounded">{{ $student->gender }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Marital Status</label>
                        <p class="border p-2 rounded">{{ $student->maritalstatus }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Spouse</label>
                        <p class="border p-2 rounded">{{ $student->spouse }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Blood Group</label>
                        <p class="border p-2 rounded">{{ $student->bloodgroup }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Education</label>
                        <p class="border p-2 rounded">{{ $student->education }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Contact Number</label>
                        <p class="border p-2 rounded">{{ $student->contact_number }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Aadhar</label>
                        <p class="border p-2 rounded">{{ $student->aadhar }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">PAN</label>
                        <p class="border p-2 rounded">{{ $student->pan }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">License</label>
                        <p class="border p-2 rounded">{{ $student->license }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">PF Number</label>
                        <p class="border p-2 rounded">{{ $student->pf_number }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">UAN Number</label>
                        <p class="border p-2 rounded">{{ $student->uan_number }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">ESI Number</label>
                        <p class="border p-2 rounded">{{ $student->esi_number }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Contact Address</label>
                        <p class="border p-2 rounded">{{ $student->contact_address }}</p>
                    </div>

                    <div>
                        <label class="font-semibold" id="contact_pincode">Pincode</label>
                        <p class="border p-2 rounded">{{ $student->contact_pincode }}</p>
                    </div>

                    <div>
                        <label class="font-semibold">Permanent Address</label>
                        <p class="border p-2 rounded">{{ $student->permanent_address }}</p>
                    </div>

                    <div>
                        <label class="font-semibold"id="permanent_pincode">Pincode</label>
                        <p class="border p-2 rounded">{{ $student->permanent_pincode }}</p>
                    </div>


                </div>


                <div class="flex gap-3 mt-4">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('students.show', $student) }}"
                            class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                            View
                        </a>

                        <a href="{{ route('students.edit', $student) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <a href="{{ route('students.my.pdf') }}"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            My PDF
                        </a>

                        <a href="{{ route('students.my.excel') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            My Excel
                        </a>

                    </div>

                </div>

            @empty
                <p class="text-center text-red-600">No students found</p>
        @endforelse

    @endif


    <div id="imgModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex justify-center items-center z-50">
        <div class="bg-white p-4 rounded relative">
            <button onclick="closeImg()" class="absolute top-2 right-2 text-red-600 font-bold text-3xl">X</button>
            <img id="popupImg" class="hidden max-h-[80vh] max-w-[80vw] rounded">
            <iframe id="popupPdf" class="hidden w-[80vw] h-[80vh] border"></iframe>
        </div>
    </div>

    <script>
        function viewFile(src, type) {
            const img = document.getElementById('popupImg');
            const pdf = document.getElementById('popupPdf');

            img.classList.add('hidden');
            pdf.classList.add('hidden');

            if (type == 'img') {
                img.src = src;
                img.classList.remove('hidden');
            } else {
                pdf.src = src;
                pdf.classList.remove('hidden');
            }

            document.getElementById('imgModal').classList.remove('hidden');
        }

        function closeImg() {
            document.getElementById('popupImg').src = '';
            document.getElementById('popupPdf').src = '';
            document.getElementById('imgModal').classList.add('hidden');
        }
    </script>

</body>

</html>
