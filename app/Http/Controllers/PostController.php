<?php namespace App\Http\Controllers;

use App\Post;
use App\Bookmark;
use Illuminate\Http\Request;
use Auth;

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
		return json_encode([
			'success' => true,
			'data' => Post::findOrFail($id)
		]);
	}

	public function create(Request $request)
	{
		$post = Post::create($request->all());
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
