<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Auth;
use App\User;

class TestController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		View::share(['user' => Auth::user()]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function auth(Request $request)
	{
		$id = $request->input('id');
		$user = User::find($id);
		if ($user) {
			Auth::login($user);
			return response()->json(['success' => true]);
		}
		return response()->json(['success' => false]);
	}

}
