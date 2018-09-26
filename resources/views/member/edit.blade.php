<form id="update-member" data-id="{{$result->id}}">
    <div class="row">
        <div class="col-6">
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
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="Enter Phone" value="{{$result->phone}}">
            </div>
            <div class="form-group">
                <label>DOB</label>
                <input type="text" class="form-control" name="dob" id="dob" value="{{$result->dob}}">
            </div>
            <div class="form-group">
                <label for="position">Position</label>
                <select class="custom-select" id="position" name="position" value="{{$result->position}}">
                    <option value="intern">Intern</option>
                    <option value="junior">Junior</option>
                    <option value="senior">Senior</option>
                    <option value="pm">PM</option>
                    <option value="ceo">CEO</option>
                    <option value="cto">CTO</option>
                    <option value="bo">BO</option>
                </select>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select class="custom-select" id="gender" name="gender" value="{{$result->gender}}">
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Avatar</label>
                <img src="{{asset('storage/avatar')}}/{{$result->avatar}}" class="img-thumbnail">
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
        </div>
        <button type="button" onClick="updateMember({{$result->id}})" class="btn btn-primary submit">Submit</button>
    </div>
</form>
