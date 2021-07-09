<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/header1.php';?>
    <title>Редактировать комментарий</title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/header2.php';?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/navbar1.php'; ?>
    <li><a href="/kabinet.php">Личный кабинет</a></li>
    <li><a href="/comment.php">Комментарии</a></li>
    <li><a href="exit.php">Выйти</a></li>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/navbar2.php'; ?>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>
        <meta http-equiv="refresh" content="0; /index.php">

        <?php else: ?>
        <?php
            include 'database.php';
            $hash = $_COOKIE['user'];
            $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
            while( $row = mysqli_fetch_assoc($result) ) { 
                $nameC = $row['name'];
            }
            
            $idForEditReplyOnComment = $_GET['replyOnCommentId'];
            $result_edit = $mysql->query("SELECT * FROM `reply_comment` WHERE `id_reply`='$idForEditReplyOnComment'");
            while( $row_edit = mysqli_fetch_assoc($result_edit) ) { 
                $edit_comment = $row_edit['reply_comment'];
                $idCommentForReplyComEdit = $row_edit['id_comment'];
            }
            
            $resultEditReplyCommentar = $mysql->query("SELECT * FROM `comments` WHERE `id`='$idCommentForReplyComEdit'");
            while( $row = mysqli_fetch_assoc($resultEditReplyCommentar) ) { 
                $edit_id = $row['id'];
            }
        ?>

        <div class="row">
            <div class="col" align="center">
                <h1>Редактировать комментарий</h1>
                <form action="checkEditReplyOnComment.php?id=<?=$idForEditReplyOnComment?>" method="post">
                <div class="mb-3">
                <label for="comment_edit" class="form-label">Комментарий будет от Вашего имени: <?=$nameC?></label>  
                <textarea class="form-control" name="comment_edit" id="comment_edit" rows="3"><?=$edit_comment?></textarea><br>
                <button class="btn btn-info" type="submit">Отредактировать комментарий</button>                  
                </form>
                <a href="/comment.php" class="btn btn-warning" >Отменить редактирование</a>
                </div>
            </div>
            <?php endif; ?>
            </div>
            
            <!--Вывод комментариев с БД-->
            <?php
            
            //Вывод БД наоборот        
            $sql = "SELECT * FROM comments ORDER BY id DESC"; 
            $result = $mysql->query($sql);
            if ($result->num_rows > 0) {

            //Имя пользователя который оставил комментарий
            while($row = $result->fetch_assoc()) {
                $user_id = $row['user_id'];
                $result2 = $mysql->query("SELECT * FROM `users` WHERE `id`='$user_id'");
                while( $row2 = mysqli_fetch_assoc($result2) ) {
                $name  = $row2['name']; 
                }
                ?>

                <br><br>
                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">

                <?php
                //Отредактировано ли сообщение или нет
                if ($row["date_edit"] != ''){
                    ?>

                    <td bgcolor='#0dd3de' align='left'>Name: <?=$name?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row["date_c"]?> (Edit: <?=$row["date_edit"]?>)</td><tr>

                    <?php
                } else {
                    ?>

                    <td bgcolor='#0dd3de' align='left'>Name: <?=$name?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row["date_c"]?></td><tr>

                    <?php   
                }
                ?>

                </table>
                <table border="0" align="center" width="75%" cellpadding="15" bordercolor="Black">

                <?php
                if ($edit_id == $row["id"]){
                    ?>

                    <td bgcolor='#adadad'><?=$row["comment"]?></td><tr>
                    
                    <?php
                } else {
                    ?>

                    <td bgcolor='white'><?=$row["comment"]?></td><tr>
                    
                    <?php
                }
                ?>
                
                </table>
                
                <?php  
                //Айди авторизированого сейчас пользователя                
                $hash = $_COOKIE['user'];
                $result3 = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
                while( $row3 = mysqli_fetch_assoc($result3) ) {
                $user_id2  = $row3['id']; 
                }
                ?>

                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">

                <?php 
                if($user_id2 == $row["user_id"]){
                //Комментарий данного авторизированого пользователя
                    if ($edit_id == $row["id"]){
                        ?>

                        <td bgcolor='#bf178a' align='right'>
                        <a style="color: Black;" href="/comment.php">Отменить редактирование</a>
                        <a style="color: Black;" href="delete_comment.php?id=<?=$row["id"]?>">Удалить</a>
                        </td><tr>

                        <?php
                    } else {                    
                ?>   

                    <td bgcolor='#eb8934' align='right'>
                    <a style="color: Black;" href="edit_comment.php?id=<?=$row["id"]?>">Редактировать</a>
                    <a style="color: Black;" href="delete_comment.php?id=<?=$row["id"]?>">Удалить</a>
                    </td><tr>
                
                <?php
                }} else {
                    //Ответить на комментарий
                    ?>

                    <td bgcolor='#eb8934' align='right'>
                        <a style="color: Black;" href="reply_comment.php?id=<?=$row["id"]?>">Ответить</a>

                <?php
                }
                ?>

                </table>
                
                <?php
                //Выводим ответ на комментарий
                //Вывод БД ответы на комменты наоборот        
                $sql_reply = "SELECT * FROM reply_comment ORDER BY id_reply DESC"; 
                $result_reply = $mysql->query($sql_reply);
                if ($result_reply->num_rows > 0) {

                    //Имя пользователя который ответил на комментарий
                    while($row_reply = $result_reply->fetch_assoc()) {
                    $id_reply_user = $row_reply['id_reply_user'];
                    $result_reply_2 = $mysql->query("SELECT * FROM `users` WHERE `id`='$id_reply_user'");
                    while( $row_reply_2 = mysqli_fetch_assoc($result_reply_2) ) {
                    $name_user_reply  = $row_reply_2['name']; 
                }

                //Проверяем, есть ли ответ на этот комментарий
                if ($row_reply['id_comment'] == $row["id"]){
                ?>

                <br><br>
                <table border="0" align="center" width="60%" cellpadding="7" bordercolor="Black">
                
                <?php
                //Отредактировано ли сообщение или нет
                if ($row_reply["edit_date_reply"] != ''){
                    ?>

                    <td bgcolor='#0dd3de' align='left'>&#9989 Name: <?=$name_user_reply?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row_reply["date_reply"]?> (Edit: <?=$row_reply["edit_date_reply"]?>)</td><tr>

                    <?php
                } else {
                    ?>

                    <td bgcolor='#0dd3de' align='left'>&#9989 Name: <?=$name_user_reply?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row_reply["date_reply"]?></td><tr>

                <?php                        
                }
                ?>

                </table>
                <table border="0" align="center" width="60%" cellpadding="15" bordercolor="Black">

                <?php
                if ($idForEditReplyOnComment == $row_reply["id_reply"]){
                    ?>

                    <td bgcolor='#adadad'><?=$row_reply["reply_comment"]?></td><tr>

                    <?php
                } else {
                    ?>
                    
                    <td bgcolor='white'><?=$row_reply["reply_comment"]?></td><tr>
                    
                    <?php
                }
                ?>
                    
                </table>
                <table border="0" align="center" width="60%" cellpadding="7" bordercolor="Black">

                <?php
                if($user_id2 == $row_reply["id_reply_user"]){
                //Комментарий данного авторизированого пользователя
                    if ($idForEditReplyOnComment == $row_reply["id_reply"]){
                        ?>

                        <td bgcolor='#bf178a' align='right'>
                        <a style="color: Black;"  href="/comment.php">Отменить редактирование</a>
                        <a style="color: Black;"  href="deleteReplyComment.php?idReplyComment=<?=$row_reply["id_reply"]?>">Удалить</a></td><tr>

                        <?php
                    } else {
                        ?>

                        <td bgcolor='#eb8934' align='right'>
                        <a style="color: Black;"  href="editReplyForComment.php?replyOnCommentId=<?=$row_reply["id_reply"]?>">Редактировать</a>
                        <a style="color: Black;"  href="deleteReplyComment.php?idReplyComment=<?=$row_reply["id_reply"]?>">Удалить</a></td><tr>
                       
                       <?php 
                    }

                } else {
                    //Ответить на комментарий
                    ?>

                    <td bgcolor='#eb8934' align='right'>
                    <a style="color: Black;" href="reply_comment.php?id=<?=$row_reply["id_reply"]?>">Ответить (off)</a>

                    <?php    
                }
                ?>

                </table>
                
                <?php
                }
                }
                }
                }
                }
                ?>

                <br><br>

                <?php
                $mysql->close();
                ?> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php'; ?>