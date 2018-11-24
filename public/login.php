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
                echo ('<section class="main-content"><h1>Ваш обліковий запис не активовано! Активуйте запис!</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');
            }
        }
        else
        {
            echo ('<section class="main-content"><h1>Пароль не вірний!</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');
        }

    }
    else
    {
        echo ('<section class="main-content"><h1>Користувач не знайден!</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');
    }
}
else
{
    echo ('<section class="main-content"><h1>Ви не заповнили усі поля</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');
}