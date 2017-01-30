<?php

use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_posts', function ($table) {
			$table->increments('id');
			$table->string('title');
			$table->text('content');
			$table->string('name')->nullable();
			$table->boolean('published')->default(1);
			$table->string('creator_id');
			$table->timestamps();
			$table->softDeletes();
			
			$table->index(array('deleted_at', 'created_at', 'published'), 'newest_blog_posts');
			
			$table->index(array('name', 'created_at', 'published'), 'idx_name');
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_posts');
	}
}
