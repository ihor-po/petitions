<?php
/**
* Keep router configs
*/
use Framework\Router;

Router::group(['namespace' => '\App\Controllers'], function() {
	Router::get('/', 'MainController@index');
	Router::post('/login', 'LoginController@login');
	Router::get('/register', 'LoginController@register');
	Router::post('/userRegister', 'RegisterController@register');
	Router::get('/confirmEmail', 'RegisterController@confirmEmail');
	Router::get('/logout', 'LoginController@logout');
	// Router::get('/error', 'LoginController@error');
	
	// Router::get('/feeds', 'MainController@feeds');
	// Router::get('/profile/{login}', 'MainController@userProfile');
	// Router::get('/settings/{login}', 'MainController@userSettings');
	// Router::post('/sendFeed', 'FeedController@sendFeed');
});