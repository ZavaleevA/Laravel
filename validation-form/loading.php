<?php
  include_once('functions.php')
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/header1.php';?>
    <title>Загрузить изображение</title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/header2.php';?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/navbar1.php'; ?>
    <li><a href= "/kabinet.php">Личный кабинет</a></li>
    <li><a href="/comment.php">Комментарии</a></li>
    <li><a href="exit.php">Выйти</a></li>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/navbar2.php'; ?>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>          

        <meta http-equiv="refresh" content="0; /index.php">
        <?php endif; ?>
    	
    	<div class="row">        
            <div class="col" align="center">
                <h2>Форма изменения фотографии</h2><br>

    				<form method="post" enctype="multipart/form-data">
      					<input type="file" class="btn btn-primary" name="file"><br><br>
      					<input type="submit" class="btn btn-success" value="Загрузить файл!">
    				</form>
    				<br>
	
		<?php
    	// если была произведена отправка формы
    	if(isset($_FILES['file'])) {
      	// проверяем, можно ли загружать изображение
      	$check = can_upload($_FILES['file']);
    
      	if($check === true){
        	// загружаем изображение на сервер
        	make_upload($_FILES['file']);
        	echo "<strong>Файл успешно загружен!</strong>";
        	?>

        	<br><h3><a style="color: Black;" href="/kabinet.php">Вернуться в личный кабинет?</a></h3><br>

        	<?php

        	$hash = $_COOKIE['user'];
        	include 'database.php';
    		$result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
    		while( $row = mysqli_fetch_assoc($result) ) { 
        	$avatar = $row['avatar'];
			}
			?>

			<h1 align="center">
			<img style="width: 50%; height: 50%;" src="<?=$avatar?>">
			</h1>

			<?php
      	} else {
        	// выводим сообщение об ошибке
        	echo "<strong>$check</strong>";  
      	}
    }
    ?>
    		</div>
    	</div>	
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php'; ?>