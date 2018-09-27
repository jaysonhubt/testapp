<form id="create-project">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Name">
                <small id="nameError" class="form-text text-danger has-error"></small>
            </div>
            <div class="form-group">
                <label>Information</label>
                <textarea class="form-control" name="information" placeholder="Enter Information"></textarea>
                <small id="informationError" class="form-text text-danger has-error"></small>
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="text" class="form-control" name="deadline" id="deadline">
                <small id="deadlineError" class="form-text text-danger has-error"></small>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="custom-select" id="type" name="type">
                    <option value="lab">Lab</option>
                    <option value="single">Single</option>
                    <option value="acceptance">Acceptance</option>
                </select>
                <small id="typeError" class="form-text text-danger has-error"></small>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="custom-select" id="status" name="status">
                    <option value="planned">Planned</option>
                    <option value="onhold">Onhold</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <small id="statusError" class="form-text text-danger has-error"></small>
            </div>
        </div>
        <button type="button" onClick="createProjectPost()" class="mx-auto btn btn-primary submit">Create</button>
    </div>
</form>
