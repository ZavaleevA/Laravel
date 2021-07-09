<?php
	$comment = filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);
	$date = date('Y-m-d H:i:s');

	if(mb_strlen($comment) < 1 || mb_strlen($comment) > 250) {
		echo "<h1 align='center'>Недопустимая длина комментария,<br> пожалуйста, введите от 1 до 250 символов и повторите попытку ";?><a href="/comment.php">еще раз</a></h1><?php
		exit();
	}
	  
    include 'database.php';
	$hash = $_COOKIE['user'];
    $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
        while( $row = mysqli_fetch_assoc($result) ) {
            $user_id  = $row['id']; 
        }
    $mysql->query("INSERT INTO `comments` (`comment`, `date_c`, `user_id`) VALUES('$comment', '$date', '$user_id ')");
	$mysql->close();
	header('Location: /comment.php');
?>