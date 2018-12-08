<?php

namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\Session;
use App\Helpers\TraitsHelper as Traits;
use App\Models\Petition;
use App\Models\UserPetition;
use App\Models\User;

class MainController extends Controller
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
        }
    }

    public function index()
    {
        $title = APP_TITLE . ' :: Вхід';

        $this->getAllPetitions($petitions);

        $isAuth = $this->userAuth;

        View::render('startPage', compact('title', 'petitions', 'isAuth'));
    }

    private function getAllPetitions(&$petitions) {
        $petitions = new Petition();
        $petitions = $petitions->getAllPetitions();

        foreach($petitions as &$petition)
        {
            $petition['signature'] = UserPetition::getPetitionSignatures($petition['id']);
        }
    }

    protected function after()
    {

    }
}