@extends('blog::layout')

@section('content')
	<div class="view-post">
		@if ($admin)
			<div class="pull-right">
				<a href="#manager/edit/{{ $post->id }}" class="btn btn-default">Edit Post</a>
				<a href="#manager" class="btn btn-default">Manager</a>
			</div>
			<div class="clearfix"></div>
		@endif
		
		<h2 class="title">
			{{ $post->title }}
		</h2>
		
		<div class="date text-muted">
			{{ $post->created_at->format('F j, Y') }}
		</div>
		
		<br>
		
		<div class="post">
			{!! $post->render() !!}
		</div>
	</div>
@stop
