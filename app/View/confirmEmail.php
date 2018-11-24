<?php

namespace App\Models;

use App\Helpers\Traits;

if (isset($_GET['email']))
{
    $usr = new User();
    $user = $usr->getUserByEmail($_GET['email']);

    if ($user != false)
    {
        if ($user['confirmed'] == 0)
        {
            $usr->confirmUser($_GET['email']);
            Traits::Redirect('/index.php?isAuth=1&email=');
        }
        echo ('<section class="main-content"><h1>Облікові данні вже були підтвержені!</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');

    }
    else
    {
        echo ('<section class="main-content"><h1>Користувач не зареєстрован!</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');
    }


}
else
{
    echo ('<section class="main-content"><h1>Помилка підтвердження</h1>
<br><a role="button" class="btn btn-outline-secondary w-25" href="index.php">На головну</a></section>');
}
