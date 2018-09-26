<form id="create-member" method="POST" action="members">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label>Information</label>
                <textarea class="form-control" name="information" placeholder="Enter Information"></textarea>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="Enter Phone">
            </div>
            <div class="form-group">
                <label>DOB</label>
                <input type="text" class="form-control" name="dob" id="dob">
                <small id="dobhelp" class="form-text text-muted">Format: YYYY-MM-DD</small>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="position">Position</label>
                <select class="custom-select" id="position" name="position">
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
                <select class="custom-select" id="gender" name="gender">
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
                <small id="dobhelp" class="form-text text-muted">Type: jpg, png, gif and less than 10MB</small>
            </div>
        </div>
        <button type="submit" onClick="createMemberPost()" class="mx-auto btn btn-primary submit">Create</button>
    </div>
</form>