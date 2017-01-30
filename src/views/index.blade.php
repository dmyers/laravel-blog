@extends('blog::layout')

@section('content')
	@if ($admin)
		<div class="pull-right">
			<a href="#manager/new" class="btn btn-default">Create Post</a>
			<a href="#manager" class="btn btn-default">Manager</a>
		</div>
		<div class="clearfix"></div>
	@endif
	
	<div class="posts">
		@foreach ($posts as $post)
			<div class="post">
				<h2 class="title">
					<a href="{{ url('blog/'.$post->name) }}" title="{{ $post->title }}">{{ $post->title }}</a>
				</h2>
				
				<div class="date text-muted">
					{{ $post->created_at->format('F j, Y') }}
				</div>
				
				<br>
				
				<div class="preview">
					{!! $post->render() !!}
				</div>
			</div>
			<hr>
		@endforeach
		
		@if ($posts->isEmpty())
			<div class="alert alert-info empty">No posts</div>
		@else
			{{ $posts->appends('q', $query)->render() }}
		@endif
	</div>
@stop
