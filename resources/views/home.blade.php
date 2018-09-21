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
				@include('member.list')
			</div>
			<div id="projects" class="tab-pane fade">
				<h3 class="mt-5">Projects List</h3>
				@include('project.list')
			</div>
		</div>
	</div>
</body>
</html
