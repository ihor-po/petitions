<?php

namespace App\Helpers;

class SessionHelper
{
	private static function issetSession() : bool
	{
		return (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) ? true : false;
	}
	
	public static function initSession($user) : void
	{
		// if (!self::issetSession())
		// {
		// 	session_start();
		// }	
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['login'] = $user['login'];
		$_SESSION['last_name'] = $user['last_name'];
		$_SESSION['first_name'] = $user['first_name'];
		$_SESSION['midle_name'] = $user['midle_name'];
		$_SESSION['email'] = $user['email'];
	}
	public static function closeSession() : void
	{
		session_unset();
		session_destroy();
	}
}