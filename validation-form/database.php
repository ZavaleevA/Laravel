<?php
	$mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');
	if ($mysql->connect_error) {
    	echo "<h1 align='center'>Connection failed: " . $mysql->connect_error?><br> Пожалуйста, повторите попытку <a href="/comment.php">еще раз</a></h1><?php
    	exit();
	}
?>