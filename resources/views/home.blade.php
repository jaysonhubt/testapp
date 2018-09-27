<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Management Application</title>
    <link rel="icon" type="image/png" href="{{asset('favicon.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/testapp.js')}}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">Project Management Application</h1>
        <ul class="nav mt-5 justify-content-center">
            <li><a data-toggle="tab" class="btn members btn-secondary mr-2" href="#members">Members</a></li>
            <li><a data-toggle="tab" class="btn projects btn-secondary" href="#projects">Projects</a></li>
        </ul>
        <div class="tab-content">
            <div id="members" class="tab-pane fade">
                <h3 class="mt-5">Members List</h3>
                <a href="#" onclick="createMember()" class="btn btn-info delete mb-2">Create Member</a>
                @include('member.list')
            </div>
            <div id="projects" class="tab-pane fade">
                <h3 class="mt-5">Projects List</h3>
                <a href="#" onclick="createProject()" class="btn btn-info delete mb-2">Create Project</a>
                @include('project.list')
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Member Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" onClick="deleteMember()" class="btn btn-primary d-none" id="delete-button">Delete</button>
                    <button type="button" onClick="deleteProject()" class="btn btn-primary d-none" id="delete-project-button">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html
