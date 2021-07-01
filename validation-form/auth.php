<?php
	$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
	$surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

	if ($name == '') {
		echo "<h1 align='center'>Вы не ввели имя, повторите попытку ";?><a href="/index.php">еще раз</a></h1><?php
		exit();
	} elseif ($surname == '') {
		echo "<h1 align='center'>Вы не ввели фамилию, повторите попытку ";?><a href="/index.php">еще раз</a></h1><?php
		exit();
	} elseif ($pass == '') {
		echo "<h1 align='center'>Вы не ввели пароль, повторите попытку ";?><a href="/index.php">еще раз</a></h1><?php
		exit();
	}
	else {
	$pass = md5($pass."dXa2cK9Mar2P4");

	$mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');

	$result = $mysql->query("SELECT * FROM `users` WHERE `name` = '$name' AND `surname` = '$surname' AND `pass` = '$pass'");
	$user = $result->fetch_assoc();
	if($user == '') {
		$mysql->close();
		echo "<h1 align='center'>Такой пользователь не найден, проверьте данные и "?><a href="/index.php">введите еще раз</a></h1><?php
		exit();
	} 
	
	$result = $mysql->query("SELECT * FROM `users` WHERE `name` = '$name' AND `surname` = '$surname' AND `pass` = '$pass'");
	while( $row = mysqli_fetch_assoc($result) ) { 
            if ($row['email_confirmed'] == 0) {
                setcookie('user', $user['name'], time() + 3600, "/");
            } else {
            	$mysql->close();
               echo "<h1 align='center'>Вы не подтвердили почту,<br> без подтвержения войти не получиться.<br> Чтобы вернуться назад, нажмите "?><a href="/index.php">сюда</a></h1><?php
               exit();
			}
        }

	$mysql->close();

	header('Location: /');
	}
?>
