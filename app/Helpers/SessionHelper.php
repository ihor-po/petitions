<?php

namespace App\Helpers;

class Session
{
	private static function issetSession() : bool
	{
		return (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? true : false;
	}
	
	public static function initSession($user) : void
	{
		if (!static::issetSession())
		{
			session_start();
		}	
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['login'] = $user['login'];
		$_SESSION['name'] = $user['name'];
	}
	public static function closeSession() : void
	{
  		session_unset();
	}
}