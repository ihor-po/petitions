<?php
namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\SessionHelper as Session;
use App\Helpers\TraitsHelper as Traits;
use App\Models\User;

class ErrorsController extends Controller
{

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
	
	public function error403()
	{
		$title = APP_TITLE . ' :: Доступ обмежений';

		echo View::template('error403.twig', compact('title'));
	}
	public function error404()
	{
		$title = APP_TITLE . ' :: Станиці не існує';

		echo View::template('error404.twig', compact('title'));
	}
	public function error405()
	{
		$title = APP_TITLE . ' :: Станиці не існує';

		echo View::template('error404.twig', compact('title'));
	}

	 protected function after()
    {
    }
}