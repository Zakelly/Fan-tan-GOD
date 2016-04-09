<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Tag extends Model {

	protected $table = 'tags';

	protected $fillable = ['name'];

	protected $hidden = ['pivot'];

	public static function findOrCreateUniqueByName($name)
	{
		$tag = self::where(['name' => $name])->first();
		if (!$tag)
		{
			$tag = self::create(['name' => $name]);
		}
		return $tag;
	}

}
