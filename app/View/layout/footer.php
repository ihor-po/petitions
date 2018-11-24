</section>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-signin">
                    <div class="form-label-group">
                        <label for="login">Логін</label>
                        <input type="text" id="login" class="form-control" placeholder="Логін" required autofocus>

                    </div>

                    <div class="form-label-group mt-2">
                        <label for="inputPassword">Пароль</label>
                        <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block text-uppercase mt-3" type="submit">Sign in</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Закрити</button>
                <a href="/?page=register" type="button" class="btn btn-outline-info">Зареєструватися</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>