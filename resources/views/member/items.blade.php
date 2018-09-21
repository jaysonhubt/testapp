@foreach ($result as $item)
    <tr data-id="{{$item->id}}">
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->phone}}</td>
        <td>{{$item->dob}}</td>
        <td>{{$item->position}}</td>
        {{$gender = 'Female'}}
        @if ($item->gender == 1)
            {{$gender = 'Male'}}
        @endif
        <td>{{$gender}}</td>
        <td><a href="#" onclick="detailMember({{$item->id}})" class="btn btn-secondary detail">Detail</a></td>
        <td><a href="#" class="btn btn-primary edit">Edit</a></td>
        <td><a href="#" class="btn btn-danger delete">Delete</a></td>
    </tr>
@endforeach
