<?php namespace App\Http\Controllers;

use App\Post;
use App\Bookmark;
use Illuminate\Http\Request;
use Auth;
use DB;

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
	
	public function get($id)
	{
		$post = Post::withContent()->withChildPosts()->findOrFail($id);
		return json_encode([
			'success' => true,
			'data' => $post
		]);
	}

	public function create(Request $request)
	{
		$input = $request->all();
		$input['user_id'] = Auth::id();

		$post = Post::create($input);
		return json_encode([
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
}
