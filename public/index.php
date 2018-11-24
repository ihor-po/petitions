<?php

session_start();

require_once ('../config/app.php');

require_once ('../app/View/layout/header.php');

require_once ('../app/db_table_prepare.php');

if (isset($_GET['page']))
{

}
else
{
    require_once ('../app/View/startPage.php');
}

require_once ('../app/View/layout/header.php');
