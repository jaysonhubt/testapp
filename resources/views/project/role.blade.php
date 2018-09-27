<div class="row">
    <div class="col-6">
        <h6>Members In Project</h6>
        @foreach ($membersHaveRole as $item)
            <p>{{$item['member_id']}}</p>
            <p>{{$item['name']}}</p>
            <p>{{$item['position']}}</p>
            <p>{{$item['role']}}</p>
        @endforeach
    </div>
    <div class="col-6">
        @foreach ($membersHaveNoRole as $item)
            <p>{{$item['id']}}</p>
            <p>{{$item['name']}}</p>
            <p>{{$item['position']}}</p>
        @endforeach
    </div>
</div>