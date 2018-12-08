</section>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вхід</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-signin" id="formSignin" method="post" >
                    <div class="form-label-group">
                        <label for="login">Логін</label>
                        <input type="text" id="login" name="login" class="form-control" placeholder="Логін" required autofocus>
                        <div class="text-danger" id="loginError"></div>
                    </div>

                    <div class="form-label-group mt-2">
                        <label for="inputPassword">Пароль</label>
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Пароль" required>
                        <div class="text-danger" id="passError"></div>
                    </div>

                    <button class="btn btn-primary btn-block text-uppercase mt-3" type="submit">Увійти</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Закрити</button>
                <a href="/register" role="button" class="btn btn-outline-info">Зареєструватися</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>