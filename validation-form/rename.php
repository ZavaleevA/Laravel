<?php
	$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
	$surname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
	$passpodtv = filter_var(trim($_POST['passpodtv']), FILTER_SANITIZE_STRING);

	$mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');
	$hash = $_COOKIE['user'];
            $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
            while( $row = mysqli_fetch_assoc($result) ) { 
                $idR = $row['id'];
                }
	if(mb_strlen($name) != 0 ) {
		if(mb_strlen($name) < 2 || mb_strlen($name) > 70) {
		echo "<h1 align='center'>Недопустимая длина имени,<br> пожалуйста, введите от 2 до 70 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
		}
		$mysql->query("UPDATE `users` SET `name`= '$name' WHERE `id`= '$idR'");
	} 
	if(mb_strlen($surname) != 0 ){
		if(mb_strlen($surname) < 2 || mb_strlen($surname) > 70) {
		echo "<h1 align='center'>Недопустимая длина фамилии,<br> пожалуйста, введите от 2 до 70 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
		}
		$mysql->query("UPDATE `users` SET `surname`= '$surname' WHERE `id`= '$idR'");
	} 
	if(mb_strlen($pass) != 0 ){
		if(mb_strlen($pass) < 4 || mb_strlen($pass) > 10) {
		echo "<h1 align='center'>Недопустимая длина пароля,<br> пожалуйста, введите от 4 до 10 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();
		} else if(mb_strlen($passpodtv) < 4 || mb_strlen($passpodtv) > 10) {
		echo "<h1 align='center'>Недопустимая длина повторного пароля,<br> пожалуйста, введите от 4 до 10 символов и повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();	
		} else if(mb_strlen($pass) != mb_strlen($passpodtv)) {
		echo "<h1 align='center'>Повторный пароль введен не верно,<br> пожалуйста, повторите попытку ";?><a href="/reg.php">еще раз</a></h1><?php
		exit();		
		}
		$pass = md5($pass."dXa2cK9Mar2P4");
		$mysql->query("UPDATE `users` SET `pass`= '$pass' WHERE `id`= '$idR'");
	}    
		
	$mysql->close();
	header('Location: /kabinet.php');
?>