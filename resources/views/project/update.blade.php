<td>{{$result->id}}</td>
<td>{{$result->name}}</td>
<td>{{$result->information}}</td>
<td>{{$result->deadline}}</td>
<td>{{$result->type}}</td>
<td>{{$result->status}}</td>
<td><a href="#" onclick="detailProject({{$result->id}})" class="btn btn-secondary detail" data-toggle="modal" data-target="#Modal">Detail</a></td>
<td><a href="#" onclick="editProject({{$result->id}})" class="btn btn-primary edit" data-toggle="modal" data-target="#Modal">Edit</a></td>
<td><a href="#" class="btn btn-danger delete">Delete</a></td>
<td><a href="#" onclick="editRole({{$item->id}})" class="btn btn-success role">Role</a></td>