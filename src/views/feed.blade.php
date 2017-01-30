<?xml version="1.0" encoding="UTF-8"?>
<feed xml:lang="en-US" xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
	<id>{{ url('blog') }}</id>
	<link rel="alternate" type="text/html" href="{{ url('blog') }}" />
	<link rel="self" type="application/atom+xml" href="{{ url('blog/feed') }}" />
	<title>{{ config('app.name') }} Blog</title>
	<updated>{{ $last_updated->toW3CString() }}</updated>
	@foreach ($posts as $post)
	<?php
	$post_desc = $post->renderPreview();
	$post_desc = str_replace("\n\n", "\n", $post_desc);
	$post_desc = str_replace("\n", ' ', $post_desc);
	$post_desc = strip_tags($post_desc);
	$post_desc = htmlspecialchars($post_desc, ENT_QUOTES);
	?>
	<entry>
		<id>{{ url('blog/'.$post->name) }}</id>
		<published>{{ $post->created_at->toW3CString() }}</published>
		<updated>{{ $post->updated_at->toW3CString() }}</updated>
		<link rel="alternate" type="text/html" href="{{ url('blog/'.$post->name) }}" />
		<title>{{ $post->title }}</title>
		<summary type="html">{{ $post_desc }}</summary>
	</entry>
	@endforeach
</feed>
