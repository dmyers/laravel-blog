<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name') }} Blog</title>
	<link rel="alternate" type="application/atom+xml" href="{{ url('blog/feed') }}" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<div class="navbar navbar-inverse navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a href="{{ url('blog') }}" class="navbar-brand">{{ config('app.name') }} Blog</a>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				@yield('content')
			</div>
			
			<div class="col-md-3">
				@include('blog::sidebar')
			</div>
		</div>
	</div>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	@if ($admin) @include('blog::manager') @endif
</html>
