<?php
    namespace App\Models;

    $petitions = new Petition();

    $petitions = $petitions->getAllPetitions();

    if (isset($_GET['subscribe']))
    {
        subscribe($_GET['subscribe']);
    }

    function subscribe($petition_id)
    {
        if (isset($_SESSION['isAuth']))
        {
            $up = new UserPetition();
            $up->createLink([
                'user_id' => $_SESSION['user_id'],
                'petition_id' => $petition_id
            ]);
        }
    }

?>

<section class="main-content">
    <div class="main-content__button">
        <a class="btn btn-outline-info" id="createPetition" href="/?page=createPetition">Створити петицію</a>
    </div>

    <div class="main-content__petitions">
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
                <div class="card-footer__subscribe">
                    <a href="/?subscribe=<?=$petition['id'] ?>" class="btn btn-outline-warning">Підписати</a>
                </div>
                <div class="card-footer__info-text">
                    Всього підписів: <span class="badge badge-danger"><?= UserPetition::getPetitionSignatures($petition['id']) ?></span>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</section>

<script src="../../public/assets/js/view/startPage.js"></script>