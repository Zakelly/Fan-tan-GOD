<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Bookmark extends Model {


	protected $table = 'bookmarks';

	protected $fillable = ['user_id', 'post_id', 'article_id'];

	protected $hidden = ['created_at'];

	public static function findUniqueByUserAndPost($user, $post)
	{
		$bookmark = self::where([
			'user_id' => $user->id,
			'post_id' => $post->id,
			'article_id' => $post->article_id
		])->first();
		return $bookmark;
	}

	public static function createUniqueByUserAndPost($user, $post)
	{
		$bookmark = self::findUniqueByUserAndPost($user, $post);
		if($bookmark) {
			$bookmark->touch();
		}
		else {
			$bookmark = self::create([
				'user_id' => $user->id,
				'post_id' => $post->id,
				'article_id' => $post->article_id
			]);
		}
		$bookmark->save();
		return $bookmark;
	}

	public static function deleteUniqueByUserAndPost($user, $post)
	{
		$bookmark = self::findUniqueByUserAndPost($user, $post);
		if($bookmark) {
			$bookmark->delete();
		}
		return true;
	}

	public function post()
	{
		return $this->belongsTo('App\Post', 'post_id');
	}

	public function article()
	{
		return $this->belongsTo('App\Article', 'article_id');
	}
}
