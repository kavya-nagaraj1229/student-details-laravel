<!DOCTYPE html>
<html>
<head>
    <style>
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; }
    </style>
</head>
<body>

<h2>Student Details</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>DOB</th>
            <th>Files</th>  {{-- NEW --}}
        </tr>
    </thead>
    <tbody>
        @foreach($students as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ $s->email }}</td>
            <td>{{ $s->age }}</td>
            <td>{{ $s->dob }}</td>
            <td>
                @if($s->files)
                    {{ implode(', ', json_decode($s->files)) }}
                @else
                    No files
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
