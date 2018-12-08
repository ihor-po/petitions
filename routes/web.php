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
	Router::get('/createPetition', 'PetitionController@index');
	Router::post('/savePetition', 'PetitionController@createPetition');
	// Router::get('/error', 'LoginController@error');
});