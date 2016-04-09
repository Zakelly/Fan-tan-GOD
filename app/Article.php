<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Article extends Model {


	protected $table = 'articles';

	protected $fillable = ['root_post_id'];

	protected $hidden = [];

	public function rootPost()
	{
		return $this->belongsTo('App\Post', 'root_post_id', 'id');
	}
}
