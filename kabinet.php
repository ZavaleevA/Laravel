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

        <meta http-equiv="refresh" content="0; /index.php">

    <?php else: ?>
        <?php
            $mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');
            $hash = $_COOKIE['user'];
            $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
            while( $row = mysqli_fetch_assoc($result) ) { 
                $nameK = $row['name'];
                $surnameK = $row['surname']; 
                $mysql->close();
                }
        ?>
        <h1 align="center"><img style="width: 35%; height: 35%;" src="photo/dog.jpg"><br>Привет, <?=$nameK?>! Чтобы выйти нажмите <a href="validation-form/exit.php">здесь</a>.</h1><br></h1><br>
        <table border="3" align="center" width="50%" cellpadding="5" bgcolor="GreenYellow" bordercolor="Black">
        <td>Name</td><td>Surname</td><td>Password</td><tr>
        <td><?=$nameK?></td> <td><?=$surnameK?></td> <td> ******* </td><tr>
        </table>
        <br>
        <div class="row">        
            <div class="col" align="center">
                <h2>Форма изменения данных</h2>
                <h3>Можно изменить все значения сразу, либо одно</h3>
                <form action="validation-form/rename.php" method="post">
                <input type="text" class="form-control" name="name" id="name" placeholder="Введите новое имя"><br>
                <input type="text" class="form-control" name="surname" id="surname" placeholder="Введите новую фамилию"><br>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите новый пароль"><br>
                <input type="password" class="form-control" name="passpodtv" id="passpodtv" placeholder="Подтвердите новый пароль"><br>
                <button class="btn btn-success" type="submit">Изменить данные</button><br><br><br>
                </form>
                </div>
            <?php endif; ?>
        </div>
    </div>  
    </body>
</html>