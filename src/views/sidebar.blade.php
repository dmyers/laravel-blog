<div class="sidebar">
	<div class="search">
		<form action="{{ url('blog/search') }}" method="get">
			<input type="text" name="q" value="" placeholder="Search Blog" class="form-control">
			<i class="fa fa-search"></i>
		</form>
	</div>
	
	@if (!$categories->isEmpty())
		<br>
		<div class="categories">
			<div class="list-group">
				@foreach ($categories as $category)
					<a href="{{ url('blog/category/'.$category->name) }}" class="list-group-item">{{ $category->title }}</a>
				@endforeach
			</div>
		</div>
	@endif
</div>
