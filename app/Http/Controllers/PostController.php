<?php namespace App\Http\Controllers;

use App\Post;
use App\Bookmark;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon;
use Validator;
use Config;

class PostController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}
	
	public function get($post_id)
	{
		$post = Post::withContent()->with('childPosts', 'article', 'user')->findOrFail($post_id);
		$post->loadAncestors(Config::get("config.default_history_count"));
		$bookmarked = Bookmark::findUniqueByUserAndPost(Auth::user(), $post);
		return view("read", compact('post', 'bookmarked'));
	}

	public function create(Request $request)
	{
		$v = Validator::make($request->all(), [
			'parent_post_id' => 'required|min:1|integer',
			'title' => 'required|max:50',
			'description' => 'max:'.Config::get('description_length'),
			'content' => 'required|max:20000',
			'terminal' => 'boolean'
		]);

		if ($v->fails())
			return response()->json([
				'success' => false,
				'data' => 0
			]);

		$input = $request->all();
		$input['user_id'] = Auth::id();

		$post = Post::create($input);
		return response()->json([
			'success' => true,
			'data' => $post
		]);
	}

	public function bookmark(Request $request, $post_id)
	{
		$post = Post::find($post_id);
		if ($post) {
			$bookmark = Bookmark::createUniqueByUserAndPost(Auth::user(), $post);
			return response()->json(['success'=>true]);
		}
		return response()->json(['success'=>false, 'data'=>1]);
	}

	public function unbookmark(Request $request, $post_id)
	{
		$post = Post::find($post_id);
		if ($post) {
			$bookmark = Bookmark::deleteUniqueByUserAndPost(Auth::user(), $post);
			return response()->json(['success'=>true]);
		}
		return response()->json(['success'=>false, 'data'=>1]);
	}

	public function bookmarks()
	{
		$user = Auth::user()->load('bookmarks.post', 'bookmarks.article.rootPost');
		return view('bookmarks', ['bookmarks' => $user->bookmarks]);
	}

	public function like($post_id)
	{
		$post = Post::find($post_id);
		if ($post) {
			$post->setLike(Auth::id(), true);
			return response()->json(['success'=>true, 'data'=>$post]);
		}
		return response()->json(['success'=>false, 'data'=>1]);
	}

	public function unlike($post_id)
	{
		$post = Post::find($post_id);
		if ($post) {
			$post->setLike(Auth::id(), false);
			return response()->json(['success'=>true, 'data'=>$post]);
		}
		return response()->json(['success'=>false, 'data'=>1]);
	}

	public function getAncestors(Request $request, $post_id)
	{
		$count = $request->get('count', Config::get("config.default_history_count"));
		$post = Post::find($post_id);
		if ($post) {
			$post->loadAncestors($count);
			return response()->json(['success'=>true, 'data'=>$post]);
		}
		return response()->json(['success'=>false, 'data'=>1]);
	}
}
