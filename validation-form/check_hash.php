<?php
	$mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1'); 
	// Проверка есть ли хеш
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    // Получаем id и подтверждено ли Email
    if ($result = $mysql->query("SELECT * FROM `users` WHERE `hash`='" . $hash . "'")) {
        while( $row = mysqli_fetch_assoc($result) ) { 
            //echo $row['id'] . " " . $row['email_confirmed'];
            // Проверяет получаем ли id и Email подтверждён ли 
            if ($row['email_confirmed'] == 1) {
                // Если всё верно, то делаем подтверждение
                $mysql->query("UPDATE `users` SET `email_confirmed`=0 WHERE `id`=". $row['id'] );
                $mysql->close();
                echo "Email подтверждён";
            } else {
                echo "Что-то пошло не так";
            }
        } 
    } else {
        echo "Что-то пошло не так";
    }
} else {
    echo "Что-то пошло не так";
}
?>