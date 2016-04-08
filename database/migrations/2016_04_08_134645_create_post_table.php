<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('parent_post_id');
			$table->integer('article_id');
			$table->string('title');
			$table->string('description');
			$table->text('content');
			$table->integer('length');
			$table->boolean('terminal')->default(0);
			$table->integer('child_count')->default(0);
			$table->integer('view_count')->default(0);
			$table->integer('like_count')->default(0);
			$table->timestamps();

			$table->index('parent_post_id');
			$table->index('user_id');
			$table->index('article_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
