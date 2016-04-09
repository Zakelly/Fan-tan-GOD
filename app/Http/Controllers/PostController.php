<?php namespace App\Http\Controllers;

use App\Post;
use App\Bookmark;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;

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
		$post = Post::withContent()->withChildPosts()->findOrFail($id);
		return response()->json([
			'success' => true,
			'data' => $post
		]);
	}

	public function create(Request $request)
	{
		$v = Validator::make($request->all(), [
			'parent_post_id' => 'required|min:1|integer',
			'title' => 'required|max:50',
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

	public function getAncestors(Request $request, $post_id)
	{
		$count = $request->get('count',0);
		$post = Post::find($post_id);
		$p = $post;
		if ($post) {
			for($i = 0 ; $i < $count ; $i ++) {
				$p->load('parentPost');
				if (!$p->parentPost)
					break;
				$p = $p->parentPost;
			}
			return response()->json(['success'=>true, 'data'=>$post]);
		}
		return response()->json(['success'=>false, 'data'=>1]);
	}
}
