<?php
	include 'database.php'; 
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
                header('Location: /index.php');
            } else {
                echo "Что-то пошло не так";
                $mysql->close();
            }
        } 
    } else {
        echo "Что-то пошло не так";
        $mysql->close();
    }
} else {
    echo "Что-то пошло не так";
    $mysql->close();
}
?>