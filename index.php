<?php include 'layouts/header1.php';?>
    <title>Форма авторизации</title>
<?php include 'layouts/header2.php';?>
<?php include 'layouts/navbar1.php'; ?>
    <li><a href="kabinet.php">Личный кабинет</a></li>
    <li><a href="comment.php">Комментарии</a></li>
    <li><a href="ads.php">Объявления</a></li>
    <li><a href="parserForUrl.php">Парсинг</a></li>
    <li><a href="reg.php">Зарегистрироваться</a></li>
    <li><a href="" class="current">Войти</a></li>
<?php include 'layouts/navbar2.php'; ?>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>

        <div class="row">
            <div class="col" align="center">
                <h1>Форма авторизации</h1>
                <form action="validation-form/auth.php" method="post">
                <input type="text" class="form-control" name="email" id="email" placeholder="Введите почту"><br>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
                <button class="btn btn-success" type="submit">Авторизоваться</button>
                </form>
                </form>
            </div>
            <?php else: ?>
        <meta http-equiv="refresh" content="0;/kabinet.php">
    <?php endif; ?>
        </div>
<?php include 'layouts/footer.php'; ?>