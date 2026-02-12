<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students List</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

<form method="POST" action="/logout" class="absolute top-4 right-4">
    @csrf
    <button type="submit"
        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Logout
    </button>
</form>

<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Students</h1>

        <!-- Only Admin -->
        @if(session('role') === 'admin')
        <div class="space-x-3">
            <a href="{{ route('students.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               + Add Student
            </a>

            <a href="{{ route('students.pdf') }}"
               class="bg-red-600 text-white px-4 py-2 rounded">
               Download PDF
            </a>
            
            <a href="{{ route('students.excel') }}"
   class="bg-green-600 text-white px-4 py-2 rounded">
   Download Excel
</a>

        </div>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Age</th>
                    <th class="p-2 border">DOB</th>

                    @if(session('role') === 'admin')
                        <th class="p-2 border">Actions</th>
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
                   
                      @if(session('role') === 'student')
                      <div class="flex justify-center mb-4 gap-3">
                        <a href="{{ route('students.pdf') }}"
                          class="bg-red-600 text-white px-4 py-2 rounded mb-3 inline-block ">
                             Download PDF
                                </a>
                                <a href="{{ route('students.excel') }}"
                              class="bg-green-600 text-white px-4 py-2 rounded mb-3 inline-block">
                                  Download Excel </a>
                                </div>
                              @endif
                    
                    @if(session('role') === 'admin')
                    <td class="p-2 border space-x-2">
                        <a href="{{ route('students.edit', $student) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <form action="{{ route('students.destroy', $student) }}" 
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
