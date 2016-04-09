<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Config;
use PhpSpec\Exception\Exception;

class Article extends Model {

	protected $table = 'articles';

	protected $fillable = ['root_post_id'];

	protected $hidden = [];

	public function rootPost()
	{
		return $this->belongsTo('App\Post', 'root_post_id', 'id');
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag', 'tag_article_relations', 'article_id', 'tag_id');
	}
	
	public function addTag($tag_id)
	{
		if (!$this->tags->contains($tag_id)) {
			if (++$this->tag_count > Config::get("config.max_tag_count"))
				throw new Exception("max tag count exceeded");
			$this->tags()->attach($tag_id);
		}
		$this->save();
	}
}
