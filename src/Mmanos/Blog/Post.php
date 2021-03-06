<?php namespace Mmanos\Blog;

use Illuminate\Support\Str;

class Post extends \Eloquent
{
	protected $table = 'blog_posts';
	protected $softDelete = true;
	protected $guarded = ['id'];
	
	public function setTitleAttribute($title)
	{
		// Strip out html tags.
		$title = strip_tags($title);
		
		// Convert &nbsp; and newlines to spaces.
		$title = str_ireplace(["&nbsp;","\n","\r"], [' ',' ',''], $title);
		
		// Truncate and trim.
		$title = Str::limit($title, 252, '...');
		
		$this->attributes['title'] = $title;
	}
	
	public function setContentAttribute($content)
	{
		// Convert \r\n and \r to \n.
		$content = str_replace("\r", "\n", str_replace("\r\n", "\n", $content));
		
		// Decode htmlspecialchars.
		$content = htmlspecialchars_decode($content);
		
		$this->attributes['content'] = $content;
	}
	
	public function render()
	{
		return \Michelf\Markdown::defaultTransform($this->content);
	}
	
	public function renderPreview()
	{
		$str_parts = explode('<!--more-->', $this->render());
		return current($str_parts);
	}
}
