<?php include 'layouts/header1.php';?>
    <title>Форма регистрации</title>
<?php include 'layouts/header2.php';?>
<?php include 'layouts/navbar1.php'; ?>
    <li><a href="kabinet.php">Личный кабинет</a></li>
    <li><a href="comment.php">Комментарии</a></li>
    <li><a href="ads.php">Объявления</a></li>
    <li><a href="parserForUrl.php">Парсинг</a></li>
    <li><a href="" class="current">Зарегистрироваться</a></li>
    <li><a href="index.php">Войти</a></li>
<?php include 'layouts/navbar2.php'; ?>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>

        <div class="row">
            <div class="col" align="center">
                <h1>Форма регистрации</h1>
                <form action="validation-form/check.php" method="post">
                <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя"><br>
                <input type="text" class="form-control" name="surname" id="surname" placeholder="Введите фамилию"><br>
                <input type="text" class="form-control" name="email" id="email" placeholder="Введите почту"><br>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
                <input type="password" class="form-control" name="passpodtv" id="passpodtv" placeholder="Подтвердите пароль"><br>
                <button class="btn btn-success" type="submit">Зарегистрироваться</button>
                </form>
            </div>
            <?php else: ?>
        <meta http-equiv="refresh" content="0;/kabinet.php">
    <?php endif; ?>
        </div>
<?php include 'layouts/footer.php'; ?>