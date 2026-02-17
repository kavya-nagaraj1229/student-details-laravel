<!DOCTYPE html>
<html>
<head>
    <title>Students PDF</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        ul { padding-left: 15px; margin: 0; }
        li { list-style: disc; }
    </style>
</head>
<body>
    <h2>All Students</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>DOB</th>
                <th>Files</th> <!-- NEW column -->
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->age }}</td>
                <td>{{ $student->dob }}</td>
                <td>
                    @if($student->files)
                        @php
                            $files = json_decode($student->files);
                        @endphp
                        <ul>
                            @foreach($files as $file)
                                <li>{{ $file }}</li>
                            @endforeach
                        </ul>
                    @else
                        None
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
