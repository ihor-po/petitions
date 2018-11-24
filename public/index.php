<?php

//namespace App\Helpers;

//require_once('../app/Helpers/s_mail.php');

session_start();

require_once ('../config/app.php');

require_once ('../app/View/layout/header.php');

require_once ('../app/db_table_prepare.php');

if (isset($_GET['page']))
{
    switch ($_GET['page'])
    {
        case 'confirmEmail':
            require_once ('../app/View/confirmEmail.php');
            break;
    }
}
else
{
    require_once ('../app/View/startPage.php');
    //MailAgent::sendEmail('Dear friend', 'info@photoigor.name');
}

require_once ('../app/View/layout/footer.php');



