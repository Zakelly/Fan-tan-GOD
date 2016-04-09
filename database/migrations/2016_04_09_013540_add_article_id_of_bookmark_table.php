<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleIdOfBookmarkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bookmarks', function(Blueprint $table)
		{
			$table->integer('article_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bookmarks', function(Blueprint $table)
		{
			$table->dropColumn('article_id');
		});
	}

}
