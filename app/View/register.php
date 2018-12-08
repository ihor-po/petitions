<?php
    require 'layout/header.php';
?>
<section class="main-content">
<form class="card bg-light register mt-3" id="register" action="/userRegister" method="post">
    <div class="card-header">Реєстрація</div>
    <div class="card-body">
    <div class="text-danger" id="registerError"><?php if (isset($errors['registerError'])) echo $errors['registerError']?></div>
        <div class="register_item">
            <label for="login">Логін</label>
            <input type="text" id="newLogin" name="newLogin" required autofocus value="<?php if (isset($data['newLogin'])) echo $data['newLogin']?>">
            <div class="text-danger" id="newLoginError"><?php if (isset($errors['newLoginError'])) echo $errors['newLoginError']?></div>
        </div>
        <div class="register_item">
            <label for="lastName">Прізвище</label>
            <input type="text" id="lastName" name="last_name" required value="<?php if (isset($data['last_name'])) echo $data['last_name']?>">
            <div class="text-danger" id="lastNameError"><?php if (isset($errors['last_nameError'])) echo $errors['last_nameError']?></div>
        </div>
        <div class="register_item">
            <label for="firstName">Ім'я</label>
            <input type="text" id="firstName" name="first_name" required value="<?php if (isset($data['first_name'])) echo $data['first_name']?>">
            <div class="text-danger" id="firstNameError"><?php if (isset($errors['first_nameError'])) echo $errors['first_nameError']?></div>
        </div>
        <div class="register_item">
            <label for="middleName">По-батькові</label>
            <input type="text" id="middleName" name="midle_name" required value="<?php if (isset($data['midle_name'])) echo $data['midle_name']?>">
            <div class="text-danger" id="middleNameError"><?php if (isset($errors['midle_nameError'])) echo $errors['midle_nameError']?></div>
        </div>
        <div class="register_item">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php if (isset($data['email'])) echo $data['email']?>">
            <div class="text-danger" id="emailError"><?php if (isset($errors['emailError'])) echo $errors['emailError']?></div>
        </div>
        <div class="register_item">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>
            <div class="text-danger" id="passError"><?php if (isset($errors['passwordError'])) echo $errors['passwordError']?></div>
        </div>
        <div class="register_item">
            <label for="confirm">Підтвердження поролю</label>
            <input type="password" id="confirm" name="confirm">
        </div>
    </div>
    <button type="submit" class="btn btn-outline-info w-25 align-self-center">Зареєструватися</button>
</form>
</section>
<?php
    require 'layout/footer.php';
?>