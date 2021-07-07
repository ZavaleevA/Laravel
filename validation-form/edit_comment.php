<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактировать комментарий</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/navigation.css">
    <style>
  body { background: url(/photo/grad1.jpg); }
</style>
</head>
<body>
    <nav class="top-menu">
    <ul class="menu-main">
    <li><a href="/kabinet.php">Личный кабинет</a></li>
    <li><a href="" class="current">Комментарии</a></li>
    <li><a href="exit.php">Выйти</a></li>
    </ul>
    </nav>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>
        <meta http-equiv="refresh" content="0; /index.php">

        <?php else: ?>
        <?php
            $mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');
            $hash = $_COOKIE['user'];
            $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
            while( $row = mysqli_fetch_assoc($result) ) { 
                $nameC = $row['name'];
            }
            $edit_id = $_GET['id'];
            $result_edit = $mysql->query("SELECT * FROM `comments` WHERE `id`='$edit_id'");
            while( $row_edit = mysqli_fetch_assoc($result_edit) ) { 
                $edit_comment = $row_edit['comment'];
            } 
            $mysql->close();   
        ?>

        <div class="row">
            <div class="col" align="center">
                <h1>Редактировать комментарий</h1>
                <form action="check_edit_comment.php?id=<?=$edit_id?>" method="post">
                <div class="mb-3">
                <label for="comment" class="form-label">Комментарий будет от Вашего имени: <?=$nameC?></label>  
                <textarea class="form-control" name="comment" id="comment" rows="3"><?=$edit_comment?></textarea><br>
                <button class="btn btn-info" type="submit">Отредактировать комментарий</button>                  
                </form>
                <button onclick="/comment.php" class="btn btn-info" type="submit">Отменить редактирование</button> 
                </div>
            </div>
            <?php endif; ?>
            </div>
            
            <!--Вывод комментариев с БД-->
            <?php
            $mysql = new mysqli('127.0.0.1', 'root', 'root', 'register-bd1');        
            //Вывод БД наоборот        
            $sql = "SELECT * FROM comments ORDER BY id DESC";
            $result = $mysql->query($sql);
            if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {

                $user_id = $row['user_id'];
                $result2 = $mysql->query("SELECT * FROM `users` WHERE `id`='$user_id'");
                while( $row2 = mysqli_fetch_assoc($result2) ) {
                $name  = $row2['name']; 
                }
                if ($edit_id == $row["id"]){
                    echo '<br>';
                    echo '<table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">';

                    //Отредактировано ли сообщение или нет
                    if ($row["date_edit"] != ''){
                    echo "<td bgcolor='#0dd3de' align='left'>Name: " . $name. "</td><td bgcolor='#0dd3de' align='right'>Time: " . $row["date_c"]. "  (Edit: " . $row["date_edit"]. ")</td><tr>";
                    } else {
                    echo "<td bgcolor='#0dd3de' align='left'>Name: " . $name. "</td><td bgcolor='#0dd3de' align='right'>Time: " . $row["date_c"]. "</td><tr>";
                    }

                    echo '</table>';
                    echo '<table border="0" align="center" width="75%" cellpadding="15" bordercolor="Black">';
                    echo "<td bgcolor='#adadad'>" . $row["comment"]. "</td><tr>";
                } else {
                    echo '<br>';
                    echo '<table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">';
                    echo "<td bgcolor='#0dd3de' align='left'>Name: " . $name. "</td><td bgcolor='#0dd3de' align='right'>Time: " . $row["date_c"]. "</td><tr>";
                    echo '</table>';
                    echo '<table border="0" align="center" width="75%" cellpadding="15" bordercolor="Black">';
                    echo "<td bgcolor='white'>" . $row["comment"]. "</td><tr>";
                }
                echo '</table>';
                                
                $hash = $_COOKIE['user'];
                $result3 = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
                while( $row3 = mysqli_fetch_assoc($result3) ) {
                $user_id2  = $row3['id']; 
                }

                if($user_id2 == $row["user_id"]){
                    echo '<table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">';

                    if ($edit_id == $row["id"]){
                        echo "<td bgcolor='#bf178a' align='right'><a style='color: Black;' ' href='/comment.php'>Отменить редактирование</a> <a style='color: Black;' ' href='delete_comment.php?id=" . $row["id"] . "'>Удалить</a></td><tr>";
                    } else {
                        echo "<td bgcolor='#eeff00' align='right'><a style='color: Black;' ' href='edit_comment.php?id=" . $row["id"] . "'>Редактировать</a> <a style='color: Black;' ' href='delete_comment.php?id=" . $row["id"] . "'>Удалить</a></td><tr>";
                    }

                    echo '</table>';
                }

                }
                echo '<br>';
                echo '<br>';
                }
                $mysql->close();
                ?> 
        </div>      
    </body>
</html>