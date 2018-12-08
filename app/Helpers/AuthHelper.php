<?php

namespace App\Helpers;

class AuthHelper
{
	public static function Auth() : bool
	{
		return (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? true : false;
	}
}
