<?php namespace Mmanos\Blog;

class Category extends \Eloquent
{
	protected $table = 'blog_categories';
	protected $softDelete = true;
	protected $guarded = array('id');
	
	public function posts()
	{
		return Blog\Post::where('category_id', $this->id)->get();
	}
}
