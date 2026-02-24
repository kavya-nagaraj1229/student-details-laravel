<!DOCTYPE html>
<html>
<head>

    <style>
    body{
        font-family: Tahoma;
        font-size:13px;
        color:#333;
    }

    h2{
        text-align:center;
        font-weight:bold;
        color:#000;
        margin-bottom:20px;
    }

    table{
        width:100%;
        border-collapse:collapse;
        font-size:12px;
    }

    th{
        border:1px solid #000;
        padding:8px;
        background: #444;;
        color:white;
        font-weight:bold;
        text-align:left;
    }

    td{
        border:1px solid #000;
        padding:6px;
        color:#000;
    }

    </style>
 
</head>

<body>

<h2>Student Details</h2>

<table>

<thead>
<tr>

<th>ID</th>
<th>Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Age</th>
<th>DOB</th>
<th>Father</th>
<th>Mother</th>
<th>Gender</th>
<th>Marital</th>
<th>Blood</th>
<th>Education</th>
<th>Contact</th>
<th>Aadhar</th>
<th>PAN</th>
<th>License</th>
<th>PF</th>
<th>UAN</th>
<th>ESI</th>
<th>Contact Address</th>
<th>Contact Pincode</th>
<th>Permanent Address</th>
<th>Permanent Pincode</th>
<th>Files</th>

</tr>
</thead>

<tbody>

@foreach($students as $s)

<tr>

<td>{{ $s->id }}</td>
<td>{{ $s->name }}</td>
<td>{{ $s->lastname }}</td>
<td>{{ $s->email }}</td>
<td>{{ $s->age }}</td>
<td>{{ $s->dob }}</td>
<td>{{ $s->fathername }}</td>
<td>{{ $s->mothername }}</td>
<td>{{ $s->gender }}</td>
<td>{{ $s->maritalstatus }}</td>
<td>{{ $s->bloodgroup }}</td>
<td>{{ $s->education }}</td>
<td>{{ $s->contact_number }}</td>
<td>{{ $s->aadhar }}</td>
<td>{{ $s->pan }}</td>
<td>{{ $s->license }}</td>
<td>{{ $s->pf_number }}</td>
<td>{{ $s->uan_number }}</td>
<td>{{ $s->esi_number }}</td>
<td>{{ $s->contact_address}}</td>
<td>{{ $s->contact_pincode }}</td>
<td>{{ $s->permanent_address}}</td>
<td>{{ $s->permanent_pincode}}</td>

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