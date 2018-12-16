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
use App\Models\UserPetition;
use DateTime;

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

		$action = 'create';
		echo View::template('createPetition.twig', compact('title', 'isAuth', 'action'));
	}

	public function createPetition() {
		if (isset($_POST) && !empty($_POST)) {

			$userId = Session::getUserId();

			if (isset($userId))
			{
				$params = [
					'title' => Validator::clean($_POST['title']),
					'petition_text' => Validator::clean($_POST['petition_text']),
					'owner_id' => $userId
				];

				$pttn = new Petition();
				$res = $pttn->select()->where('title', $params['title'])->get();

				if (empty($res))
				{
					$date = new DateTime("NOW");
					$newPetition = new Petition();
					$newPetition->title = $params['title'];
					$newPetition->petition_text = $params['petition_text'];
					$newPetition->owner_id = $userId;
					$newPetition->created_date = $date->format('Y-m-d H:i:s');
					$newPetition->save();

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

		$action = 'create';
		$title = APP_TITLE . ':: Створення петиції';
		echo View::template('createPetition.twig', compact('isAuth', 'data', 'errors', 'action'));
	}

	/**
	 * Get petition for edit
	 */
	public function editPetition($petitionId){
		$petition = new Petition($petitionId);
		$data = [
			'id' => $petition->id,
			'title' => $petition->title,
			'petition_text' => $petition->petition_text
		];
		$action = "edit";
		$isAuth = $this->userAuth;
		$title = APP_TITLE . ':: Редагування петиції';
		echo View::template('createPetition.twig', compact('isAuth', 'data', 'errors', 'action', 'title'));
	}

	/**
	 * Update petition data
	 */
	public function updatePetition(){
		$data = [
			'id' => (isset($_POST['id'])) ? $_POST['id'] : "",
			'title' => (isset($_POST['title'])) ? $_POST['title'] : "",
			'petition_text' => (isset($_POST['petition_text'])) ? $_POST['petition_text'] : ""
		];
		
		if (isset($_POST) && !empty($_POST)) {
			$userId = Session::getUserId();

			if (isset($userId)) {
				$petition = new Petition($data['id']);

				$res = false;
				if ($data['title'] != $petition->title){
					$tmp = new Petition();
					$res = $tmp->getOne('title', $data['title']);
				}
				
				if (!$res)
				{
					$petition->title = $data['title'];
					$petition->petition_text = $data['petition_text'];
					$petition->save();

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

		$action = 'edit';
		$title = APP_TITLE . ':: Редагування петиції';
		echo View::template('createPetition.twig', compact('isAuth', 'data', 'errors', 'action'));
	}

	public function subscribePetition($pttn)
	{
		$petitions = new Petition();
		$pttn = $petitions->getOne('id',$pttn);

		if ($pttn)
		{
			$up = new UserPetition();
			$up = $up
				->where('petition_id', $pttn['id'])
				->where('user_id', Session::getUserId())
				->get();
	
			if (empty($up))
			{
				$up = new UserPetition();
				$up->user_id = Session::getUserId();
				$up->petition_id = $pttn['id'];
				$up->save();

				Traits::Redirect('/');
			}
			else
			{
				$errors['subscribe'] = urldecode('Ви вже підписали дану петицію!');
			}
		}
		else
		{
			$errors['subscribe'] = "Петиція не знайдена! Помилка підпису!";
		}
		$isAuth = $this->userAuth;
		$this->getAllPetitions($petitions);
		echo View::template('startPage.twig', compact('isAuth', 'petitions', 'errors'));
	}

	public function removePetition($petitionId) {
		$petition = new Petition($petitionId);
		$res = $petition->delete();
		Traits::Redirect('/');
	}

	private function getAllPetitions(&$petitions) {
        $petitions = new Petition();
        $petitions = $petitions->all('DESC', 'created_date');

        foreach($petitions as &$petition)
        {
            $signatures = new UserPetition();
            $signatures = $signatures
                            ->select()
                            ->where('petition_id', $petition['id'])
                            ->get();
            
            $petition['signature'] = count($signatures);
        }
	}

	 protected function after()
    {
    }
}