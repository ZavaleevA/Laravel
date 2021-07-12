<?php
    $id = $_GET['id'];
	
	//Удаляем главный комментарий
	// Create connection
	include 'database.php';
	// Check connection
	if ($mysql->connect_error) {
    	echo "<h1 align='center'>Connection failed: " . $mysql->connect_error?><br> Пожалуйста, повторите попытку <a href="/comment.php">еще раз</a></h1><?php
    	exit();
	}
	//$sql = "SELECT id_reply, reply_comment, id_comment, id_reply_user, date_reply, edit_date_reply FROM reply_comment";
	//$sql = "DELETE FROM `reply_comment` WHERE `reply_comment`.`id_comment` = $id";
	$result = $mysql->query("SELECT * FROM `comments` WHERE `id` = '$id'");
	$sql = "SELECT id, comment, date_c, user_id FROM comments";
	$sql = "DELETE FROM `comments` WHERE `comments`.`id` = $id";

	$result = $mysql->query($sql);
	$mysql->close();

	//Удаляем все под-комментарии под-главного
	include 'database.php';

	$result = $mysql->query("SELECT * FROM `reply_comment` WHERE `id_comment` = '$id'");

	while( $rowIdComment = mysqli_fetch_assoc($result) ) { 
        $idComment = $rowIdComment['id_reply'];

		$mysql->close();
		include 'database.php';
		$resultD = $mysql->query("SELECT * FROM `reply_comment` WHERE `id_sub_comment` = '$idComment'");
        $sql = "SELECT id_reply, reply_comment, id_comment, id_sub_comment, id_reply_user, date_reply, edit_date_reply FROM reply_comment";
		$sql = "DELETE FROM `reply_comment` WHERE `reply_comment`.`id_sub_comment` = $idComment";
		$mysql->close();
		include 'database.php';

	}
	
	$result = $mysql->query($sql);
	$mysql->close();

	//Удаляем все под-комментарии главного
	include 'database.php';

	$result = $mysql->query("SELECT * FROM `reply_comment` WHERE `id_comment` = '$id'");
	$sql = "SELECT id_reply, reply_comment, id_comment, id_sub_comment, id_reply_user, date_reply, edit_date_reply FROM reply_comment";
	$sql = "DELETE FROM `reply_comment` WHERE `reply_comment`.`id_comment` = $id";
	
	$result = $mysql->query($sql);
	$mysql->close();
	
	header('Location: /comment.php');
?>