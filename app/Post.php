<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpSpec\Exception\Exception;
use Config;

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
		'description',
		'content',
		'terminal'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['likers'];

	private static $defaultFetch = [
		'id', 'user_id', 'parent_post_id',
		'article_id', 'title', 'description',
		'length', 'terminal', 'child_count',
		'view_count', 'like_count'
	];

	public static function create(array $attributes)
	{
		if ($attributes['parent_post_id'] > 0)
		{
			$parent = Post::findOrFail($attributes['parent_post_id']);
			if ($parent->terminal)
				throw new Exception("trying to append to terminal node");
			if (++$parent->child_count > Config::get('config.max_child_count'))
				throw new Exception("max count exceeded");
			$parent->save();
			
			$attributes['article_id'] = $parent->article_id;
		}
		return parent::create($attributes);
	}

	public static function boot()
	{
		parent::boot();

		Post::saving(function ($post)
		{
			if ($post->content) {
				$post->length = mb_strlen($post->content);
				if (!$post->description || strlen($post->description) == 0)
					$post->description = substr($post->content, 0, Config::get("config.description_length"));
			}
		});
	}

	public function newQuery($excludeDeleted = true)
	{
		return parent::newQuery()->select(Post::$defaultFetch);
	}

	public function scopeWithContent($query)
	{
		return $query->addSelect('content');
	}

	public function scopeWithChildPosts($query)
	{
		return $query->with('childPosts');
	}
	
	public function isLiked($user_id)
	{
		return $this->likers->contains($user_id);
	}
	
	public function setLike($user_id, $to)
	{
		if ($this->isLiked($user_id) == $to)
			return;
		if ($to) {
			$this->likers()->attach($user_id);
			$this->like_count++;
		} else {
			$this->likers()->detach($user_id);
			$this->like_count--;
		}
		$this->save();
	}

	public function parentPost()
	{
		return $this->belongsTo('App\Post', 'parent_post_id', 'id');
	}

	public function childPosts()
	{
		return $this->hasMany('App\Post', 'parent_post_id', 'id');
	}
	
	public function likers()
	{
		return $this->belongsToMany('App\User', 'post_like_relations', 'post_id', 'user_id');
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
