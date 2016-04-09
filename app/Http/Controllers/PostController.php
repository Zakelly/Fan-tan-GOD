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
		return response()->json([
			'success' => true,
			'data' => $post
		]);
	}

	public function create(Request $request)
	{
		$this->validate($request, [
			'parent_post_id' => 'required|min:1|integer',
			'title' => 'required|max:50',
			'content' => 'required|max:20000',
			'terminal' => 'boolean'
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
}
