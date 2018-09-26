<td>{{$result->id}}</td>
<td>{{$result->name}}</td>
<td>{{$result->phone}}</td>
<td>{{$result->dob}}</td>
<td>{{$result->position}}</td>
@php
    $gender = 'Female';
    if ($result->gender == 1)
    {
        $gender = 'Male';
    }
@endphp
<td>{{$gender}}</td>
<td><a href="#" onclick="detailMember({{$result->id}})" class="btn btn-secondary detail" data-toggle="modal" data-target="#Modal">Detail</a></td>
<td><a href="#" onclick="editMember({{$result->id}})" class="btn btn-primary edit" data-toggle="modal" data-target="#Modal">Edit</a></td>
<td><a href="#" class="btn btn-danger delete">Delete</a></td>