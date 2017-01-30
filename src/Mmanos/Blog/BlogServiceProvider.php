<?php namespace Mmanos\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app->router->group(['namespace' => 'Mmanos\Blog'], function($router) {
			include __DIR__.'/../../routes.php';
		});
		
		$this->publishes([
			__DIR__.'/../../config/blog.php' => config_path('blog.php'),
		]);
		
		$this->publishes([
			__DIR__.'/../../migrations/' => database_path('migrations'),
		], 'migrations');
		
		$this->loadViewsFrom(__DIR__.'/../../views', 'blog');
		
		$this->publishes([
			__DIR__.'/../../views' => base_path('resources/views/vendor/blog'),
		]);
		
		$this->publishes([
			__DIR__.'/../../../public/libs/' => public_path('vendors'),
			__DIR__.'/../../../public/css/' => public_path('css/blog'),
			__DIR__.'/../../../public/js/' => public_path('js/blog'),
		], 'public');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
