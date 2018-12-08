<?php
    require 'layout/header.php';
?>
<section class="main-content">
    <?php if (isset($isAuth) && $isAuth) { ?>
    <div class="main-content__button">
        <a class="btn btn-outline-info" id="createPetition" href="/?page=createPetition">Створити петицію</a>
    </div>
    <?php } ?>

    <div class="main-content__petitions mt-3">
        <?php
        foreach ($petitions as $petition)
        { ?>
        <div class="card text-center">
            <div class="card-header">
                <?= $petition['title'] ?>
            </div>
            <div class="card-body">
                <p class="card-text"><?= $petition['petition_text']?></p>
            </div>
            <div class="card-footer text-muted">
                <div class="card-footer__info-text">
                    <span>Дата: <?= $petition['created_date'] ?></span>
                </div>
                <?php if (isset($isAuth) && $isAuth) { ?>
                <div class="card-footer__subscribe">
                    <a href="/?subscribe=<?=$petition['id'] ?>" class="btn btn-outline-warning">Підписати</a>
                </div>
                <?php } ?>
                <div class="card-footer__info-text">
                    Всього підписів: <span class="badge badge-danger"><?= $petition['signature'] ?></span>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</section>

<script src="/assets/js/view/startPage.js"></script>
<?php
    require 'layout/footer.php';
?>