<?php namespace Mmanos\Blog\Service;

/**
 * The Blog Category service.
 */
class Category
{
	/**
	 * Create a new Category.
	 *
	 * @param string       $title
	 * @param int|string   $creator_id
	 * @param array        $options
	 * 
	 * @return \Mmanos\Blog\Category
	 * @throws Exception
	 */
	public static function create($title, $creator_id, array $options = [])
	{
		$category = new \Mmanos\Blog\Category([
			'title'      => $title,
			'creator_id' => $creator_id,
		]);
		
		if (!empty($options['description'])) {
			$category->description = $options['description'];
		}
		
		if (!empty($options['name'])) {
			$category->name = $options['name'];
		}
		else {
			$category->name = \Str::slug($category->title);
		}
		
		$category->save();
		
		return $category;
	}
	
	/**
	 * Update a Category.
	 *
	 * @param \Mmanos\Blog\Category $category
	 * @param array                 $options
	 * 
	 * @return void
	 * @throws Exception
	 */
	public static function update(\Mmanos\Blog\Category $category, array $options = [])
	{
		if (!empty($options['title'])) {
			$category->title = $options['title'];
		}
		
		if (!empty($options['description'])) {
			$category->description = $options['description'];
		}
		
		if (!empty($options['name'])) {
			$category->name = $options['name'];
		}
		
		$category->save();
	}
	
	/**
	 * Delete a Category.
	 *
	 * @param \Mmanos\Blog\Category $post
	 * 
	 * @return void
	 * @throws Exception
	 */
	public static function delete(\Mmanos\Blog\Category $category)
	{
		$posts = $category->posts;
		
		foreach ($posts as $post) {
			$post->category_id = null;
			$post->save();
		}
		
		$category->delete();
	}
}
