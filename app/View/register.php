<section class="main-content">
<form class="card bg-light register mt-3" id="register" action="register_f.php" method="post">
    <div class="card-header">Реєстрація</div>
    <div class="card-body">
        <div class="register_item">
            <label for="login">Логін</label>
            <input type="text" id="login" name="login" required autofocus>
        </div>
        <div class="register_item">
            <label for="lastName">Прізвище</label>
            <input type="text" id="lastName" name="last_name" required>
        </div>
        <div class="register_item">
            <label for="firstName">Ім'я</label>
            <input type="text" id="firstName" name="first_name" required>
        </div>
        <div class="register_item">
            <label for="middleName">По-батькові</label>
            <input type="text" id="middleName" name="midle_name" required>
        </div>
        <div class="register_item">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="register_item">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>
        </div>
    </div>
    <button type="submit" class="btn btn-outline-info w-25 align-self-center">Зареєструватися</button>
</form>
</section>
