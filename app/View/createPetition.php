<section class="main-content">
    <form class="card bg-light register mt-3" id="register" action="create_petition.php?login=<?=$_SESSION['login']?>" method="post">
        <div class="card-header">Створити петицію</div>
        <div class="card-body">
            <div class="register_item">
                <label for="title">Назва петиції</label>
                <input type="text" id="title" name="title" required autofocus>
            </div>
            <div class="register_item">
                <label for="petition_text">Текст петиції</label>
                <textarea name="petition_text" id="petitionText" rows="4" style="resize: none;"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-info w-25 align-self-center">Створити петицію</button>
    </form>
</section>
