<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagArticleRelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_article_relations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tag_id');
			$table->integer('article_id');

			$table->timestamps();

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
		Schema::drop('tag_article_relations');
	}

}
