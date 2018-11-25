<?php
    namespace App\Models;

    use App\Helpers\Traits;

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
            $usr = new User();
            $user = $usr->getUserByLogin($_SESSION['login']);

            if ($user != false)
            {
                $up = new UserPetition();

                if (!$up->getPetitionUserSignatures($petition_id, $user['id']))
                {
                    $up->createLink([
                        'user_id' => $user['id'],
                        'petition_id' => $petition_id
                    ]);
                }
                else
                {
                    Traits::ShowError('Ви вже підписали дану петицію!');
                }
            }
        }
    }

?>

<section class="main-content">
    <?php if(isset($_SESSION['isAuth'])) { ?>
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
                <?php if(isset($_SESSION['isAuth'])) { ?>
                <div class="card-footer__subscribe">
                    <a href="/?subscribe=<?=$petition['id'] ?>" class="btn btn-outline-warning">Підписати</a>
                </div>
                <?php } ?>
                <div class="card-footer__info-text">
                    Всього підписів: <span class="badge badge-danger"><?= UserPetition::getPetitionSignatures($petition['id']) ?></span>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</section>

<script src="../../public/assets/js/view/startPage.js"></script>