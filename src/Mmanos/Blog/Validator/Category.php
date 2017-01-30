<?php namespace Mmanos\Blog\Validator;

/**
 * Blog Category validator(s).
 */
class Category
{
	/**
	 * Default messages for this class.
	 *
	 * @var array
	 */
	public static $messages = [
		'name_available' => 'This name is already taken.',
	];
	
	/**
	 * Create Category validator.
	 *
	 * @return Validator
	 */
	public static function create(array $input, array $rules = [], array $messages = [])
	{
		$rules = array_merge($rules, [
			'title' => 'required|min:1',
			'name'  => 'name_available',
		]);
		
		return \Validator::make($input, $rules, $messages);
	}
	
	/**
	 * Update Category validator.
	 *
	 * @return Validator
	 */
	public static function update(array $input, array $rules = [], array $messages = [])
	{
		static::registerNameAvailable($post);
		
		$rules = array_merge($rules, [
			'name' => 'name_available',
		]);
		
		return \Validator::make($input, $rules, $messages);
	}
	
	/*************************************************************************/
	/* Custom Validation Rules                                               */
	/*************************************************************************/
	
	/**
	 * Register custom rule: name_available.
	 *
	 * @param \Mmanos\Blog\Category $category
	 * 
	 * @return void
	 */
	public static function registerNameAvailable(\Mmanos\Blog\Category $category = null)
	{
		\Validator::extend('name_available', function ($attribute, $value, $parameters) use ($category) {
			$existing = \Mmanos\Blog\Category::where('name', '=', $value)->first();
			
			if (!$existing) {
				return true;
			}
			
			if ($category) {
				if ($category->id == $existing->id) {
					return true;
				}
			}
			
			return false;
		});
	}
}
