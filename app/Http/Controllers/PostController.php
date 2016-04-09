<?php namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

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
}
