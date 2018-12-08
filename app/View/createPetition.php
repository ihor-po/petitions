<?php
    require 'layout/header.php';
?>
<section class="main-content">
    <form class="card bg-light register mt-3" id="register" action="/savePetition" method="post">
        <div class="card-header">Створити петицію</div>
        <div class="card-body">
        <div class="text-danger"><?php if (isset($errors['createPetitionError'])) echo $errors['createPetitionError'] ?></div>
            <div class="register_item">
                <label for="title">Назва петиції</label>
                <input type="text" id="title" name="title" required autofocus value="<?php if (isset($data['title'])) echo $data['title'] ?>" >
            </div>
            <div class="register_item">
                <label for="petition_text">Текст петиції</label>
                <textarea name="petition_text" id="petitionText" rows="4" style="resize: none;"><?php if (isset($data['petition_text'])) echo $data['petition_text'] ?></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-info w-25 align-self-center">Створити петицію</button>
    </form>
</section>
<?php
    require 'layout/footer.php';
?>