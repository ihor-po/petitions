<?php

session_start();

require_once ('../config/app.php');

require_once ('../app/View/layout/header.php');

require_once ('../app/db_table_prepare.php');

if (isset($_GET['page']))
{
    switch ($_GET['page'])
    {
        case 'register':
            require_once ('../app/View/register.php');
            break;
        case 'sendEmail':
            require_once ('../app/View/sendEmail.php');
            break;
        case 'confirmEmail':
            require_once ('../app/View/confirmEmail.php');
            break;
    }
}
else
{
    require_once ('../app/View/startPage.php');
}

require_once ('../app/View/layout/footer.php');



