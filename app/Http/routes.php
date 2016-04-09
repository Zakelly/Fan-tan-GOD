<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('post/{id}', 'PostController@get');

Route::post('post/{post_id}/bookmark', ['middleware' => 'auth', 'uses' => 'PostController@bookmark']);
Route::post('post', ['middleware' => 'auth', 'uses' => 'PostController@create']);

Route::post('article', 'ArticleController@create');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('/test/auth', 'TestController@auth');