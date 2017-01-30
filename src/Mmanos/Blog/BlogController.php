<?php namespace Mmanos\Blog;

use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;

/**
 * Blog controller.
 * 
 * @author Mark Manos
 * @author Derek Myers
 */
class BlogController extends BaseController
{
	protected $categories;
	
	public function __construct()
	{
		$categories = Category::all();
		\View::share('categories', $categories);
	}
	
	/**
	 * Index action.
	 * 
	 * @return View
	 */
	public function getIndex()
	{
		$posts = Post::where('published', true)
			->orderBy('created_at', 'desc')
			->paginate(5);
		
		$view_params = [
			'admin' => false,
			'posts' => $posts,
			'query' => null,
		];
		
		$fn = \Config::get('blog.is_admin');
		if ($fn && $fn()) {
			$view_params['admin'] = true;
		}
		
		return \View::make('blog::index', $view_params);
	}
	
	/**
	 * Show action.
	 * 
	 * @return View
	 */
	public function getShow($name)
	{
		$post = Post::where('name', $name)
			->where('published', true)
			->first();
		
		if (!$post) {
			abort(404);
		}
		
		$view_params = [
			'admin' => false,
			'post'  => $post,
		];
		
		$fn = \Config::get('blog.is_admin');
		if ($fn && $fn()) {
			$view_params['admin'] = true;
		}
		
		return \View::make('blog::show', $view_params);
	}
	
	/**
	 * Search action.
	 * 
	 * @return View
	 */
	public function getSearch()
	{
		$query = Input::get('q');
		
		$posts = Post::where('published', true)
			->where('title', 'like', "%$query%")
			->orderBy('created_at', 'desc')
			->paginate(5);
			
		$view_params = [
			'admin' => false,
			'posts' => $posts,
			'query' => $query,
		];
		
		$fn = \Config::get('blog.is_admin');
		if ($fn && $fn()) {
			$view_params['admin'] = true;
		}
		
		return \View::make('blog::index', $view_params);
	}
	
	/**
	 * Category action.
	 * 
	 * @return View
	 */
	public function getCategory($name)
	{
		$category = Category::where('name', $name)->first();
		if (!$category) {
			abort(404);
		}
		
		$posts = Post::where('category_id', $category->id)
			->where('published', true)
			->orderBy('created_at', 'desc')
			->paginate(5);
			
		$view_params = [
			'admin' => false,
			'posts' => $posts,
			'query' => null,
		];
		
		$fn = \Config::get('blog.is_admin');
		if ($fn && $fn()) {
			$view_params['admin'] = true;
		}
		
		return \View::make('blog::index', $view_params);
	}
	
	/**
	 * Archive action.
	 * 
	 * @return View
	 */
	public function getArchive($year, $month)
	{
		if (!is_numeric($year) || !is_numeric($month)) {
			abort(404);
		}
		if (strlen($year) != 4 || strlen($month) != 2) {
			abort(404);
		}
		
		$date = Carbon::create($year, $month, 1, 12, 0, 0);
		$date_start = (string) $date->startOfMonth();
		$date_end = (string) $date->endOfMonth();
		
		$posts = Post::where('published', true)
			->where('created_at', '>=', $date_start)
			->where('created_at', '<=', $date_end)
			->orderBy('created_at', 'desc')
			->paginate(5);
		
		$view_params = [
			'admin' => false,
			'posts' => $posts,
			'query' => null,
		];
		
		$fn = \Config::get('blog.is_admin');
		if ($fn && $fn()) {
			$view_params['admin'] = true;
		}
		
		return \View::make('blog::index', $view_params);
	}
	
	/**
	 * Feed action.
	 * 
	 * @return View
	 */
	public function getFeed()
	{
		$posts = Post::where('published', true)
			->orderBy('created_at', 'desc')
			->get();
		
		$last_post = $posts[count($posts) -1];
		$last_updated = $last_post->created_at;
		
		$view_params = [
			'posts'        => $posts,
			'last_updated' => $last_updated,
		];
		
		return \View::make('blog::feed', $view_params);
	}
}
