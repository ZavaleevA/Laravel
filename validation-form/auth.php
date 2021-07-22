<?php
	$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

	if ($email == '') {
		echo "<h1 align='center'>Вы не ввели почту, повторите попытку ";?><a href="/index.php">еще раз</a></h1><?php
		exit();
	} elseif ($pass == '') {
		echo "<h1 align='center'>Вы не ввели пароль, повторите попытку ";?><a href="/index.php">еще раз</a></h1><?php
		exit();
	}
	else {
	$pass = md5($pass."dXa2cK9Mar2P4");

	include 'database.php';

	$result = $mysql->query("SELECT * FROM `users` WHERE `email` = '$email' AND `pass` = '$pass'");
	$user = $result->fetch_assoc();
	if($user == '') {
		$mysql->close();
		echo "<h1 align='center'>Такой пользователь не найден, проверьте данные и "?><a href="/index.php">введите еще раз</a></h1><?php
		exit();
	} 
	
	$result = $mysql->query("SELECT * FROM `users` WHERE `email` = '$email' AND `pass` = '$pass'");
	while( $row = mysqli_fetch_assoc($result) ) { 
            if ($row['email_confirmed'] == 0) {
            	$hash = $row['hash'];
            	setcookie('user', $user['hash'], time() + 3600, "/");
                } else {
            	$mysql->close();
               echo "<h1 align='center'>Вы не подтвердили почту,<br> без подтвержения войти не получиться.<br> Чтобы вернуться назад, нажмите "?><a href="/index.php">сюда</a></h1><?php
               exit();
			}
        }

	$mysql->close();

	header('Location: /index.php');
	}
?>