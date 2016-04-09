<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'parent_post_id',
		'article_id',
		'title',
		'content',
		'terminal'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	private static $defaultFetch = [
		'id', 'user_id', 'parent_post_id',
		'article_id', 'title', 'description',
		'length', 'terminal', 'child_count',
		'view_count', 'like_count'
	];

	public static function boot()
	{
		parent::boot();

		Post::saving(function ($post)
		{
			if ($post->content) {
				$post->length = mb_strlen($post->content);
				$post->description = substr($post->content, 0, 20);
			}
		});
	}

	public function newQuery($excludeDeleted = true)
	{
		return parent::newQuery()->select(Post::$defaultFetch);
	}

	public function scopeWithContent()
	{
		return $this->select('*');
	}

	public function scopeWithChildPosts()
	{
		return $this->with('childPosts');
	}

	public function parentPost()
	{
		return $this->belongsTo('App\Post', 'parent_post_id', 'id');
	}

	public function childPosts()
	{
		return $this->hasMany('App\Post', 'id', 'parent_post_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function article()
	{
		return $this->belongsTo('App\Article', 'article_id', 'id');
	}
}
