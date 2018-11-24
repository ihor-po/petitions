<?php
namespace App\Helpers;

require_once('../app/Helpers/s_mail.php');
require_once('../app/Helpers/traits.php');
require_once('../app/Models/User.php');
require_once ('../config/app.php');

use App\Models\User;

if (isset($_POST) && !empty($_POST))
{
    $user = new User();

    $params = [
        'login' => $_POST['login'],
        'last_name' => $_POST['last_name'],
        'first_name' => $_POST['first_name'],
        'midle_name' => $_POST['midle_name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirmed' => 0
    ];

    if ($user->createUser($params))
    {
        $name = $_POST['last_name'] . ' ' . $_POST['first_name'] . ' ' . $_POST['midle_name'];
        MailAgent::sendEmail($name, $_POST['email']);
        Traits::Redirect('/?page=sendEmail');
    }
    else
    {
        Traits::Redirect('/?error=register');
    }
}
