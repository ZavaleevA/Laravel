<?php
    $id = $_GET['id'];
	$servername = "127.0.0.1";
	$username = "root";
	$password = "root";
	$dbname = "register-bd1";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
    	echo "<h1 align='center'>Connection failed: " . $conn->connect_error?><br> Пожалуйста, повторите попытку <a href="/comment.php">еще раз</a></h1><?php
    	exit();
	}

	$result = $conn->query("SELECT * FROM `comments` WHERE `id` = '$id'");
	$sql = "SELECT id, comment, date_c, user_id FROM comments";
	$sql = "DELETE FROM `comments` WHERE `comments`.`id` = $id";
	$result = $conn->query($sql);
	$conn->close();
	header('Location: /comment.php');
?>