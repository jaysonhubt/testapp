<div class="row">
    <div class="col-12">
        <h6>Members In Project</h6>
        @foreach ($membersHaveRole as $item)
        <div class="row border border-primary mb-2">
            <div class="col-6">
                <p><span class="font-weight-bold">Member's Id: </span>{{$item['member_id']}}</p>
                <p><span class="font-weight-bold">Member's Name: </span>{{$item['name']}}</p>
            </div>
            <div class="col-6">
                <p><span class="font-weight-bold">Member's Positon: </span>{{$item['position']}}</p>
                <p><span class="font-weight-bold">Member's Role: </span>{{$item['role']}}</p>
            </div>
        </div>
        @endforeach
        @foreach ($membersHaveNoRole as $item)
        <p>{{$item['id']}}</p>
        <p>{{$item['name']}}</p>
        <p>{{$item['position']}}</p>
        @endforeach
    </div>
</div>