<div class="row">
    <div class="col-6">
        <p>Id: {{$result->id}}</p>
        <p>Name: {{$result->name}}</p>
        <p>Information: {{$result->information}}</p>
        <p>Phone: {{$result->phone}}</p>
        <p>DOB: {{$result->dob}}</p>
        <p>Position: {{$result->position}}</p>
        @php
            $gender = 'Female';
            if ($result->gender == 1)
            {
                $gender = 'Male';
            }
        @endphp
        <p>Gender: {{$gender}}</p>
    </div>
    <div class="col-6">
        <p>Avatar: </p>
        <img src="{{asset('storage/avatar')}}/{{$result->avatar}}" class="img-thumbnail">
    </div>
</div>
