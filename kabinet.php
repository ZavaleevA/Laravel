<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Личный кабинет</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navigation.css">
    <style>
  body { background: url(photo/grad1.jpg); }
</style>
</head>
<body>
    <nav class="top-menu">
    <ul class="menu-main">
    <li><a href= "" class="current">Личный кабинет</a></li>
    <li><a href="reg.php">Зарегистрироваться</a></li>
    <li><a href="index.php">Войти</a></li>
    </ul>
    </nav>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>          

        <meta http-equiv="refresh" content="0;https://zadanie1/index.php">

    <?php else: ?>
        <h1 align="center"><img style="width: 35%; height: 35%;" src="photo/dog.jpg"><br>Привет, <?=$_COOKIE['user']?>! Чтобы выйти нажмите <a href="validation-form/exit.php">здесь</a>.</h1><br></h1>
    <?php endif; ?>
</div>
    </div>  
</body>
</html>