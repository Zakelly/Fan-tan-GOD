<?php namespace App\Http\Controllers;

use App\Article;
use App\Post;
use App\Bookmark;
use Illuminate\Http\Request;
use Auth;

class ArticleController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function create(Request $request)
	{
		$input = $request->all();
		$input['user_id'] = Auth::id();

		$post = Post::create($input);
		$article = Article::create(['root_post_id' => $post->id]);
		$post->article_id = $article->id;
		$post->save();
		return json_encode([
			'success' => true,
			'data' => $post
		]);
	}
}
