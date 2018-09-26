@foreach ($result as $item)
    <tr id="{{$item->id}}">
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->information}}</td>
        <td>{{$item->deadline}}</td>
        <td>{{$item->type}}</td>
        <td>{{$item->status}}</td>
        <td><a href="#" onclick="detailProject({{$item->id}})" class="btn btn-secondary detail" data-toggle="modal" data-target="#Modal">Detail</a></td>
        <td><a href="#" onclick="editProject({{$item->id}})" class="btn btn-primary edit" data-toggle="modal" data-target="#Modal">Edit</a></td>
        <td><a href="#" class="btn btn-danger delete">Delete</a></td>
    </tr>
@endforeach
