@foreach ($result as $item)
    <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->information}}</td>
        <td>{{$item->deadline}}</td>
        <td>{{$item->type}}</td>
        <td>{{$item->status}}</td>
        <td><a href="#" class="btn btn-secondary detail">Detail</a></td>
        <td><a href="#" class="btn btn-primary edit">Edit</a></td>
        <td><a href="#" class="btn btn-danger delete">Delete</a></td>
    </tr>
@endforeach
