<?php
namespace App\Models;

use App\Helpers\Traits;

require_once ('../app/Helpers/traits.php');
require_once ('../config/app.php');
require_once ('../app/Models/User.php');
require_once ('../app/Models/Petition.php');

if (isset($_POST) && isset($_GET))
{
    if (!empty($_POST['title']) && !empty($_POST['petition_text']))
    {
        $user = new User();
        $user = $user->getUserByLogin($_GET['login']);

        if ($user)
        {
            $params = [
                'title' => $_POST['title'],
                'petition_text' => $_POST['petition_text'],
                'owner_id' => $user['id']
            ];
            $pttn = new Petition();

            if (!$pttn->getPetitionsByTitle($_POST['title']))
            {
                $pttn = $pttn->createPetition($params);
                \App\Helpers\Traits::Redirect('index.php');
            }
            else
            {
                \App\Helpers\Traits::ShowError('Петиції вже існує!');
            }
        }
        else
        {
            \App\Helpers\Traits::ShowError('Користувач не існує!<br>Створення петиіїї не можливе!');
        }
    }
    else
    {
        \App\Helpers\Traits::ShowError('Ви не заповнили усі поля!');
    }
}
else
{
    \App\Helpers\Traits::ShowError('Ви вже підписали дану петицію!');
}