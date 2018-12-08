<?php
namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper as Auth;
use App\Helpers\TraitsHelper as Traits;
use App\Models\User;
use App\Helpers\ValidationHelper as Validation;
use App\Helpers\MailAgentHelper as MailAgent;
use App\Helpers\SessionHelper as Session;

class RegisterController extends Controller
{
	private $isAuth;
	private $mainTitle;
	protected $user;
	protected function before()
    {
    	$mainTitle = APP_TITLE;
    	if (Auth::Auth())
    	{
    		//Traits::Redirect('/feed');
    	}
    }

	public function register()
	{
        $title = APP_TITLE . ' :: Реєстрація';
        
        $data = [];
        $errors = [];

		if (!empty($_POST))
		{
            foreach($_POST as $key => $value){
                if ($key != 'password') {
                    $data[$key] = $value;
                }
            }

            foreach ($_POST as $key => $item)
            {
                if (Validation::requiredFields($item))
                {
                    $errors[$key . 'Error'] = "Обов'язкове поле не заповнене!";
                }
            }

            if (count($errors) > 0) {
                return View::render('register', compact('errors', 'title', 'data'));
            }

            if (Validation::email($_POST['email']))
            {
                $user = new User();
                $user = $user->getUserByEmail(Validation::clean($_POST['newLogin']));

                if (!$user)
                {
                    $user = new User();
                    $user = $user->getUserByEmail(Validation::clean($_POST['email']));
                    
                    if(!$user)
                    {
                        if (!Validation::password($_POST['password'], $_POST['confirm']))
                        {
                            $errors['passwordError'] = 'Помилка заповнення паролю!';	
                        }
                    }
                    else
                    {
                        $errors['emailError'] = 'Email вже існує!';
                    }
                }
                else
                {
                    $errors['newLogin'] = 'Логин вже існує!';	
                }
            }
            else
            {
                $errors['emailError'] = 'Email невірний';
            }
		}
		else
		{
			$errors['registerError'] = 'Помилка відправлення даних';
        }
        
        if (empty($error)){
            
            $userData = [
                'login' => Validation::clean($_POST['newLogin']),
                'last_name' => Validation::clean($_POST['last_name']),
                'first_name' => Validation::clean($_POST['first_name']),
                'midle_name' => Validation::clean($_POST['midle_name']),
                'email' => Validation::clean($_POST['email']),
                'password' => $_POST['password'],
                'confirmed' => 0
            ];
        
            $user = new User();
            if ($user->createUser($userData))
            {
                $name = $userData['last_name'] . ' ' . $userData['first_name'] . ' ' . $userData['midle_name'];
                MailAgent::sendEmail($name, $userData['email']);
                
                $user = new User();
                $user = $user->getUserByLogin($userData['login']);

                Session::initSession($user);
                var_dump($_SESSION);die;
                  //  Traits::Redirect('/feeds');
            }
            else
            {
                $error = 'Ошибка создания пользователя!';		
            }
        }

		return View::render('register', compact('errors', 'title', 'data'));
    }
    
    public function confirmEmail() {
        $errors = [];
        if (isset($_GET) && !empty($_GET))
        {
            $usr = new User();
            $user = $usr->getUserByEmail($_GET['email']);
            if ($user != false)
            {
                if ($user['confirmed'] == 0)
                {
                    $usr->confirmUser($_GET['email']);
                }
                else
                {
                    $errors['confirmError'] = 'Облікові данні вже були підтвердженні!';    
                }
            }
            else
            {
                $errors['confirmError'] = 'Користувач не зареєстрован!';
            }
        }
        else
        {
            $errors['confirmError'] = 'Помилка підтвердження';
        }
        return View::render('/confirmEmail', compact('errors'));
    }

    protected function after()
    {
    }
}