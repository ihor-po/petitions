<?php

namespace App\Models;

use App\Helpers\Traits;

require_once ('../config/app.php');
require_once ('../app/Models/User.php');
require_once ('../app/Helpers/traits.php');

if (isset($_POST) && !empty($_POST['login']) && !empty($_POST['password']))
{
    $usr = new User();

    $user = $usr->getUserByLogin($_POST['login']);

    if ($user != false)
    {
        if (password_verify($_POST['password'], $user['password']))
        {
            if ($user['confirmed'] == 1)
            {
                Traits::Redirect('index.php?login=' . $user['login']);
            }
            else
            {
                Traits::ShowError('Ваш обліковий запис не активовано!<br>Активуйте запис!');
            }
        }
        else
        {
            Traits::ShowError('Пароль не вірний!');
        }
    }
    else
    {
        Traits::ShowError('Користувач не знайден!');
    }
}
else
{
    Traits::ShowError('Ви не заповнили усі поля');
}