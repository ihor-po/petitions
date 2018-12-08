<?php

namespace App\Helpers;

class ValidationHelper
{
	public static function requiredFields(...$_fields) : bool
	{
		$fields = func_get_args();
		$fieldsCount = count($fields);
		if ($fieldsCount > 1)
		{
			foreach ($fields as $field) 
			{	
				if (empty($field))
				{
					return false;
				}
			}
		}
		else
		{
			if (empty($field))
			{
				return false;
			}
		}
		return true;
	}
	/**
	* Очистка от html тегов
	*/
	public static function clean($value = "") 
	{
	    $value = trim($value);
	    $value = stripslashes($value);
	    $value = strip_tags($value);
	    $value = htmlspecialchars($value);
    
    return $value;
	}
	/**
	* Проверка длины строки
	*/
	public static function length($value, int $min, int $max = 255) : bool
	{
		if (strlen($value) < $min || strlen($value) > $max)
		{
			return false;
		}
		return true;
	}
	/**
	* Валидация email
	*/
	public static function email($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	/**
	* Валидация пароля
	*/
	public static function password($password, $confirm)
	{
		$pattern = '/^[A-Za-z0-9-_!@#]*$/';
		if ($password != $confirm)
		{
			return false;
		}
		if (!self::length($password, 6))
		{
			return false;
		}
		return preg_match($pattern, $password);
	}
}