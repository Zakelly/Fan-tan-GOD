<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostLikeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_like_relations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post_id');
			$table->integer('user_id');

			$table->timestamps();

			$table->index('post_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_like_relations');
	}

}
