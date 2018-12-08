<?php
namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\Session;
use App\Helpers\TraitsHelper as Traits;
use App\Models\User;

class LoginController extends Controller
{
	private $userAuth;

	protected function before()
    {
    if (AuthHelper::Auth())
    	{
			$this->userAuth = true;
			Traits::Redirect("/");
        }
        else
        {
            $this->userAuth = false;
        }
	}
	
	public function login()
	{
		$title = APP_TITLE . ' :: Вхід';
		
		if (isset($_POST) && !empty($_POST['login']) && !empty($_POST['password']))
		{
			$user = new User();
			$user = $user->getUserByLogin($_POST['login']);
			
			if (isset($user) && $user)
			{
				if (password_verify($_POST['password'], $user['password']))
				{
					Session::initSession($user);
				}
				else
				{
					$passError = "Неверный пароль!";
				}
			}
			else
			{		 
			   $loginError = "Такого пользователя не существует!";
			}
		}
		else
		{
			$error = "Вы не ввели данные для входа";
		}

		if (isset($loginError) || isset($passError))
		{
			if (isset($loginError))
			{
				$output['loginError'] = $loginError;
			}

			if (isset($passError))
			{
				$output['passError'] = $passError;
			}
			$output['success'] = false;
		}
		else
		{
			$output['success'] = true;
		}

		return json_encode($output);
	}

	 public function register()
	 {
	 	$title = APP_TITLE . ' :: Реєстрація';
	 	View::render('register', compact('title'));
	 }
	 public function error()
	 {
	 	$title = APP_TITLE . ' :: ERROR';
	 	View::render('404', compact('title'));
	 }

	 

	 protected function after()
    {
    }
}