<?php
	$mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');
	$edit_id = $_GET['id'];
   	$comment = filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);
	$date = date('Y-m-d H:i:s');

	if(mb_strlen($comment) < 1 || mb_strlen($comment) > 250) {
		echo "<h1 align='center'>Недопустимая длина комментария,<br> пожалуйста, введите от 1 до 250 символов и повторите попытку ";?><a href="edit_comment.php">еще раз</a></h1><?php
		$mysql->close();
		exit();
	}
	  
    $mysql->query("UPDATE `comments` SET `comment` = '$comment', `date_edit` = '$date'WHERE `id`= '$edit_id'");
	$mysql->close();
	header('Location: /comment.php');
?>