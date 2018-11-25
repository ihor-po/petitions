<?php
require_once '../app/View/layout/header.php';
$message = (isset($_GET) && isset($_GET['error'])) ? urldecode($_GET['error']) : 'Помилка!';
echo ("<section class=\"w-100 h-100 d-flex justify-content-center align-items-center flex-column\">
<h1 class='text-danger'>$message</h1>
<br><a role=\"button\" class=\"btn btn-outline-secondary w-25\" href=\"index.php\">На головну</a></section>");
require_once '../app/View/layout/footer.php';