<body class="app">
<section class=" container text-left">
    <h1 class="h4 pt-5 fadeIn wow" data-wow-delay=".5s"><strong>TO</strong>aster<strong>DO</strong></h1>
</section>
<section>
    <div class="container">

        <form class="p-5 wow fadeIn" data-wow-delay="1.1s" method="post">

            <div class="col-12 h4 text-center py-2">
                Новый пользователь
            </div>
            <div class="col-12 text-center small py-3">
                Поля отмеченные * обязательны для заполнения
            </div>

            <div class="row">

                <div class="col-md-6">
                    <label>Эл. почта*</label>
                    <input class="col-12 mb-3 " name="login" type="email" placeholder="mail_name@gmail.com" required>
                </div>

                <div class="col-md-6">
                    <label>Придумайте пароль*</label>
                    <input class="col-12 mb-4 " name="password" type="password" required minlength="4" maxlength="20" placeholder="от 4 до 30 символов">
                </div>

                <div class="col-md-6">
                    <label>Повторите пароль*</label>
                    <input class="col-12 mb-4 " name="double_password" type="password" required minlength="4" maxlength="20" placeholder="от 4 до 30 символов">
                </div>


                <div class="col-12 pt-sm-3 text-center">
                    <input class="sub" type="submit" value="Добавить пользователя">
                </div>

        </form>

    </div>

</section>