@foreach ($result as $item)
    <tr id="{{$item->id}}">
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->phone}}</td>
        <td>{{$item->dob}}</td>
        <td>{{$item->position}}</td>
        @php
            $gender = 'Female';
            if ($item->gender == 1)
            {
                $gender = 'Male';
            }
        @endphp
        <td>{{$gender}}</td>
        <td><a href="#" onclick="detailMember({{$item->id}})" class="btn btn-secondary detail" data-toggle="modal" data-target="#Modal">Detail</a></td>
        <td><a href="#" onclick="editMember({{$item->id}})" class="btn btn-primary edit" data-toggle="modal" data-target="#Modal">Edit</a></td>
        <td><a href="#" onclick="confirmDeleteMember({{$item->id}})" class="btn btn-danger delete">Delete</a></td>
    </tr>
@endforeach
