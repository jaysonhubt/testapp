<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Project Management Application</title>
	<link rel="icon" type="image/png" href="{{asset('favicon.png')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
	<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/testapp.js')}}"></script>
</head>
<body>
	<div class="container">
		<h1 class="mt-5 text-center">Project Management Application</h1>
		<ul class="nav mt-5 justify-content-center">
			<li><a data-toggle="tab" class="btn btn-secondary mr-2" href="#menu1">Members</a></li>
			<li><a data-toggle="tab" class="btn btn-secondary" href="#menu2">Projects</a></li>
		</ul>

		<div class="tab-content">
			<div id="menu1" class="tab-pane fade">
				<h3 class="mt-5">Members List</h3>
				@include('member.list')
			</div>
			<div id="menu2" class="tab-pane fade">
				<h3 class="mt-5">Projects List</h3>
				@include('project.list')
			</div>
		</div>
	</div>
</body>
</html