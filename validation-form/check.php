<?php
	$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
	$surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
	$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
	$passpodtv = filter_var(trim($_POST['passpodtv']), FILTER_SANITIZE_STRING);

	if(mb_strlen($name) < 2 || mb_strlen($name) > 70) {
		echo "<h1 align='center'>Недопустимая длина имени,<br> пожалуйста, введите от 2 до 70 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
	} else if(mb_strlen($surname) < 2 || mb_strlen($surname) > 70) {
		echo "<h1 align='center'>Недопустимая длина фамилии,<br> пожалуйста, введите от 2 до 70 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
	} else if(mb_strlen($email) < 10 || mb_strlen($email) > 100) {
		echo "<h1 align='center'>Недопустимая длина почты,<br> пожалуйста, введите от 10 до 100 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
	} else if(mb_strlen($pass) < 4 || mb_strlen($pass) > 10) {
		echo "<h1 align='center'>Недопустимая длина пароля,<br> пожалуйста, введите от 4 до 10 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
	} else if(mb_strlen($passpodtv) < 4 || mb_strlen($passpodtv) > 10) {
		echo "<h1 align='center'>Недопустимая длина повторного пароля,<br> пожалуйста, введите от 4 до 10 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();	
	} else if(mb_strlen($pass) != mb_strlen($passpodtv)) {
		echo "<h1 align='center'>Повторный пароль введен не верно,<br> пожалуйста, повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();		
	}

	$hash = md5($name . time());

	$server = $_SERVER['HTTP_HOST'];

	//Отправляем письмо подтверждения почты
	mail($email, 'Подтверждение почты', 'Чтобы подтвердить Email, перейдите по ссылке: http://' . substr($server, strrpos($server, '/')) . '/validation-form/check_hash.php?hash=' . $hash . '', 'From: zavaleev.sbase@gmail.com');
    
    $pass = md5($pass."dXa2cK9Mar2P4");
        
        // Добавление пользователя в БД
	include 'database.php';
	$mysql->query("INSERT INTO `users` (`name`, `surname`, `email`, `pass`, `hash`, `email_confirmed`) VALUES('$name', '$surname', '$email', '$pass', '$hash', '1')");

	echo "<h1 align='center'>Вы успешно зарегистрировались,<br> чтобы войти в свой аккаунт нужно подтвредить почту, чтобы выйти - нажмите ";?><a href="/reg.php">здесь</a></h1><?php
		
	$mysql->close();
?>