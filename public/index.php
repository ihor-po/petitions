<?php

session_start();

require_once ('../config/app.php');
require_once ('../app/View/layout/header.php');
require_once ('../app/db_table_prepare.php');
require_once ('../app/Helpers/traits.php');

if (isset($_GET['page']))
{
    switch ($_GET['page'])
    {
        case 'register':
            require_once ('../app/View/register.php');
            break;
        case 'auth':
            require_once ('../app/View/startPage.php');
            break;
        case 'sendEmail':
            require_once ('../app/View/sendEmail.php');
            break;
        case 'confirmEmail':
            require_once ('../app/View/confirmEmail.php');
            break;
        case 'logout':
            require_once ('../app/Helpers/traits.php');
            $_SESSION = [];
            session_destroy();
            \App\Helpers\Traits::Redirect('index.php');
            break;
    }
}
else
{
    if (isset($_GET) && isset($_GET['login']))
    {
        $_SESSION['isAuth'] = 1;
        $_SESSION['login'] = $_GET['login'];
        \App\Helpers\Traits::Redirect('index.php?page=auth');
    }
    require_once ('../app/View/startPage.php');
}

require_once ('../app/View/layout/footer.php');



