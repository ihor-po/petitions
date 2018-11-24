<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="ua" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <title>Електронні Петиції</title>
    <link rel="stylesheet" href="../../../public/assets/css/reset.css">
    <link rel="stylesheet" href="../../../public/assets/css/main.css">
    <link rel="stylesheet" href="../../../public/libs/bootstrap/css/bootstrap.min.css">
    <script src="../../../public/libs/jquery/jquery-3.3.1.min.js"></script>
    <script src="../../../public/libs/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<header class="d-inline-flex justify-content-center">
    <div class="header">
        <div class="header__title">
            <h1 class="header__title__text">Електронні петиції</h1>
        </div>
        <?php if(!isset($_SESSION['isAuth']))
        {
            echo "<button type=\"button\" class=\"btn btn-outline-primary\" data-toggle=\"modal\" data-target=\"#loginModal\">Увійти</button>";
        }
        else
        {
            echo "<a role=\"button\" class=\"btn btn-outline-primary\" href=\"\?page=logout\">Вийти</a>";
        } ?>
    </div>
</header>
<section class="d-flex flex-column w-100 h-100 justify-content-center">
