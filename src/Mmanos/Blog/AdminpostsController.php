<?php namespace Mmanos\Blog;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;

/**
 * Admin Blog Posts controller.
 * 
 * @author Mark Manos
 */
class AdminpostsController extends BaseController
{
	/**
	 * Instantiate a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Check for admin.
		$fn = \Config::get('blog.is_admin');
		if (!$fn || !$fn()) {
			abort(404);
		}
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Post::query()
			->take(Input::get('num', 20))
			->skip((Input::get('page', 1) - 1) * Input::get('num', 20))
			->get()
			->toArray();
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = Validator\Post::create(Input::all());
		if ($validation->fails()) {
			abort(400, $validation->errors());
		}
		
		$current_user_id = 0;
		$fn = \Config::get('blog.current_user');
		if ($fn) {
			$current_user_id = $fn();
		}
		
		$post = Service\Post::create(
			Input::get('content'),
			$current_user_id,
			Input::all()
		);
		
		return $post->toArray();
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$post = Post::find($id);
		if (!$post) {
			abort(404);
		}
		
		return $post->toArray();
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$post = Post::find($id);
		if (!$post) {
			abort(404);
		}
		
		$validation = Validator\Post::update($post, Input::all());
		if ($validation->fails()) {
			abort(400, $validation->errors());
		}
		
		Service\Post::update($post, Input::all());
		
		return $post->toArray();
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$post = Post::find($id);
		if (!$post) {
			abort(404);
		}
		
		Service\Post::delete($post);
	}
	
	/**
	 * Check to see if the requested name is available.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function namecheck($name)
	{
		$original  = $name;
		$name      = Str::slug($name);
		$permalink = null;
		
		for ($i = 0; $i < 50; $i++) {
			$tmp_perm = ($i == 0) ? $name : $name . $i;
			
			$taken = Post::where('name', '=', $tmp_perm)->first();
			
			if (!$taken || $taken->id == Input::get('id')) {
				$permalink = $tmp_perm;
				break;
			}
		}
		
		return [
			'permalink' => $permalink,
			'changed'   => ($permalink !== $original),
		];
	}
	
	/**
	 * QQ (FineUploader) Image upload action.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function qq()
	{
		$input = Input::all();
		
		$validation = \Validator::make($input, [
			'qqfile' => 'required'
		]);
		
		if ($validation->fails()) {
			abort(400, $validation->errors());
		}
		
		$file = array_get($input, 'qqfile');
		$filename = md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
		$uploadpath = $file->getPathname();
		$storagepath = 'blog/images';
		$filepath = $storagepath.'/'.$filename;
		
		try {
			\Storage::putFileAs($storagepath, $file, $filename, 'public');
		}
		catch (Exception $e) {
			abort(500, "Error creating image ({$e->getMessage()}).");
		}
		
		try {
			$url = \Storage::url($filepath);
		}
		catch (Exception $e) {
			abort(500, "Error getting image URL ({$e->getMessage()}).");
		}
		
		$url = \Config::get('app.url').$url;
		
		return ['url' => $url];
	}
}
