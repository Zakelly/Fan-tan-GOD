<?php namespace App\Http\Controllers;

use App\Post;
use App\Bookmark;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use View;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
		View::share(['user' => Auth::user()]);
	}
	
	public function index()
	{
		return view('home');
	}
}
