<?php
/**
* Keep router configs
*/
use Framework\Router;
use Pecee\Http\Request;
use App\Helpers\TraitsHelper;

//Router::get('/not-found', 'PageController@notFound');

Router::error(function(Request $request, \Exception $exception) {
	switch($exception->getCode()) {
		case 404:
			TraitsHelper::ReloadPage('/error404');
			break;
		case 403:
			TraitsHelper::ReloadPage('/error403');
			break;
		case 500:
			TraitsHelper::ReloadPage('/error500');
			break;
	}
	
    // if($exception instanceof NotFoundHttpException && $exception->getCode() === 404) {
    //     response()->redirect('/error404');
    // }
    
});

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
	
	Router::get('/error404', 'ErrorsController@error404');
	Router::get('/error403', 'ErrorsController@error403');
	Router::get('/error500', 'ErrorsController@error500');
});