<?php
    require 'layout/header.php';
?>
<section class="main-content">
    <?php if (isset($errors) && !empty($errors['confirmError'])) { ?>
        <h1 class="text-danger"><?= $errors['confirmError']?></h1>
    <?php } else { ?>
        <h1 class="text-success">Облікові данні підтвержені!</h1>
    <?php } ?>
    <br><a role="button" class="btn btn-outline-secondary w-25" href="/">На головну</a>
    </section>
<?php 
    require 'layout/footer.php';
?>
