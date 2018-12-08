<?php
/**
* Keep router configs
*/
use Framework\Router;

Router::group(['namespace' => '\App\Controllers'], function() {
	Router::get('/', 'MainController@index');
	Router::get('/register', 'LoginController@register');
	Router::get('/confirmEmail', 'RegisterController@confirmEmail');
	Router::get('/logout', 'LoginController@logout');
	Router::get('/createPetition', 'PetitionController@index');
	Router::get('/subscribePetition/{petitionId}', 'PetitionController@subscribePetition');
	Router::post('/login', 'LoginController@login');
	Router::post('/savePetition', 'PetitionController@createPetition');
	Router::post('/userRegister', 'RegisterController@register');
	// Router::get('/error', 'LoginController@error');
});