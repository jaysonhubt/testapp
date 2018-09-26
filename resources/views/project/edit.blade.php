<form id="update-project" data-id="{{$result->id}}">
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{$result->name}}">
            </div>
            <div class="form-group">
                <label>Information</label>
                <textarea class="form-control" name="information" placeholder="Enter Information">{{$result->information}}</textarea>
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="text" class="form-control" name="deadline" id="dob" value="{{$result->deadline}}">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="custom-select" id="type" name="type" value="{{$result->type}}">
                    <option value="lab">Lab</option>
                    <option value="single">Single</option>
                    <option value="acceptance">Acceptance</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="custom-select" id="status" name="status" value="{{$result->status}}">
                    <option value="planned">Planned</option>
                    <option value="onhold">Onhold</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <button type="button" onClick="updateProject({{$result->id}})" class="btn btn-primary submit mx-auto">Submit</button>
    </div>
</form>
