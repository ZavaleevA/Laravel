<?php
    $id = $_GET['idReplyComment'];
	
	// Create connection
	include 'database.php';
	// Check connection
	if ($mysql->connect_error) {
    	echo "<h1 align='center'>Connection failed: " . $mysql->connect_error?><br> Пожалуйста, повторите попытку <a href="/comment.php">еще раз</a></h1><?php
    	exit();
	}

	$result = $mysql->query("SELECT * FROM `reply_comment` WHERE `id_reply` = '$id'");
	$sql = "SELECT id_reply, reply_comment, id_comment, id_reply_user, date_reply, edit_date_reply FROM reply_comment";
	$sql = "DELETE FROM `reply_comment` WHERE `reply_comment`.`id_reply` = $id";
	$result = $mysql->query($sql);
	$mysql->close();
	header('Location: /comment.php');
?>