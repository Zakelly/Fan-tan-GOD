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

	public static function createUniqueByUserAndPost($user, $post)
	{
		$bookmark = self::where([
			'user_id' => $user->id,
			'post_id' => $post->id,
			'article_id' => $post->article_id
		])->first();
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

}
