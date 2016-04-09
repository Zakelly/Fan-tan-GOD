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

	public function parentPost()
	{
		return $this->belongsTo(Post::class, 'parent_post_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function article()
	{
		return $this->belongsTo(Article::class, 'article_id', 'id');
	}
}
