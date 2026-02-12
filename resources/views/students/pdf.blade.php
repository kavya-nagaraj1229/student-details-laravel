<h2>Students List</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Age</th><th>DOB</th>
    </tr>
    @foreach($students as $s)
    <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->NAME }}</td>
        <td>{{ $s->email }}</td>
        <td>{{ $s->age }}</td>
        <td>{{ $s->dob }}</td>
    </tr>
    @endforeach
</table>
