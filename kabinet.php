<?php $location  = 'kabinet'; 
include 'layouts/header.php';
include 'layouts/navbar.php'; ?>


    <div class="container mt-4">

        <?php if (!isset($_COOKIE['user'])): ?>          

        <meta http-equiv="refresh" content="0; /index.php">

    <?php else: 
        include 'validation-form/database.php';
        $hash = $_COOKIE['user'];
        $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
        while( $row = mysqli_fetch_assoc($result) ) { 
            $nameK = $row['name'];
            $surnameK = $row['surname'];
            $avatar = $row['avatar']; 
            $mysql->close();
            }?>
        <h1 align="center">
        <?php if ($avatar == ''){
                $avatar = '/photo/dog.jpg';
            }?>

        <img style="width: 35%; height: 35%;" src="<?=$avatar?>"><br>Привет, <?=$nameK?>! Чтобы выйти нажмите <a href="validation-form/exit.php">здесь</a>.</h1><br></h1><br>
        <table border="3" align="center" width="50%" cellpadding="5" bgcolor="GreenYellow" bordercolor="Black">
        <td>Name</td><td>Surname</td><td>Password</td><tr>
        <td><?=$nameK?></td> <td><?=$surnameK?></td> <td> ******* </td><tr>
        </table>
        <br>
        <div class="row">        
            <div class="col" align="center">
                <h2>Форма изменения данных</h2>
                <h3>Можно изменить все значения сразу, либо одно</h3>
                <form action="validation-form/rename.php" method="post">
                <textarea class="form-control" name="name" id="name" rows="1"><?=$nameK?></textarea><br>
                <textarea class="form-control" name="surname" id="surname" rows="1"><?=$surnameK?></textarea><br>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите новый пароль"><br>
                <input type="password" class="form-control" name="passpodtv" id="passpodtv" placeholder="Подтвердите новый пароль"><br>
                <button class="btn btn-success" type="submit">Изменить данные</button>
                <a href="validation-form/loading.php" class="btn btn-primary" >Поменять фото</a>
                <a href="validation-form/delete_photo.php" class="btn btn-danger" >Удалить фото</a><br><br><br>
                </form>
            </div>
        </div>
    <?php endif; 
include 'layouts/footer.php'; ?>