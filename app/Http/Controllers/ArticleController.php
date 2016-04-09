<?php namespace App\Http\Controllers;

use App\Article;
use App\Post;
use App\Tag;
use App\Bookmark;
use Illuminate\Http\Request;
use View;
use Auth;

class ArticleController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
		View::share(['user' => Auth::user()]);
	}
	
	public function getCreate()
	{
		return view('post-new');
	}

	public function create(Request $request)
	{
		$input = $request->all();
		$input['user_id'] = Auth::id();
		$input['parent_post_id'] = 0;

		$post = Post::create($input);
		$article = Article::create(['root_post_id' => $post->id]);
		$post->article_id = $article->id;
		$post->save();
		return response()->json([
			'success' => true,
			'data' => $post,
			'redirect' => route('post.view', $post->id)
		]);
	}

	public function addTag($article_id, Request $request)
	{
		$tagName = $request->input("tag_name");
		$article = Article::findOrFail($article_id);
		$tag = Tag::findOrCreateUniqueByName($tagName);
		$article->addTag($tag->id);

		return response()->json([
			'success' => true,
			'data' => $article
		]);
	}

	public function get($article_id)
	{
		$article = Article::with('tags')->findOrFail($article_id);
		return response()->json([
			'success' => true,
			'data' => $article
		]);
	}
}
