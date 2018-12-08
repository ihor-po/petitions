<?php
namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\SessionHelper as Session;
use App\Helpers\TraitsHelper as Traits;
use App\Models\User;
use App\Helpers\ValidationHelper as Validator;
use App\Models\Petition;

class PetitionController extends Controller
{
	private $userAuth;

	protected function before()
    {
		if (AuthHelper::Auth())
		{
			$this->userAuth = true;
		}
		else
		{
			$this->userAuth = false;
			Traits::Redirect('/');
		}
	}
	
	public function index() {
		$title = APP_TITLE . ' :: Створення петиції';

        $isAuth = $this->userAuth;

        return View::render('createPetition', compact('title', 'isAuth'));
	}

	public function createPetition() {
		if (isset($_POST) && !empty($_POST)) {
			$user = new User();
			$user = $user->getUserByLogin($_SESSION['login']);

			if ($user)
			{
				$params = [
					'title' => Validator::clean($_POST['title']),
					'petition_text' => Validator::clean($_POST['petition_text']),
					'owner_id' => $user['id']
				];
				$pttn = new Petition();
	
				if (!$pttn->getPetitionsByTitle($params['title']))
				{
					$pttn = $pttn->createPetition($params);
					Traits::Redirect('/');
				}
				else
				{
					$errors['createPetitionError'] = 'Така петиція вже інує!';
				}
			}
			else
			{
				$errors['createPetitionError'] = 'Користувач не знайден';	
			}
		}
		else
		{
			$errors['createPetitionError'] = 'Помилка передачі данних!';
		}
		$isAuth = $this->userAuth;
		$data = [
			'title' => (isset($_POST['title'])) ? $_POST['title'] : "",
			'petition_text' => (isset($_POST['petition_text'])) ? $_POST['petition_text'] : ""
		];

		return View::render('createPetition', compact('isAuth', 'data', 'errors'));
	}

	 protected function after()
    {
    }
}