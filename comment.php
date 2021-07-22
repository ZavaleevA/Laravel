<?php $location  = 'comment';
include 'layouts/header.php';
include 'layouts/navbar.php'; ?>

    <div class="container mt-4">

        <?php if (!isset($_COOKIE['user'])): ?>
        <meta http-equiv="refresh" content="0; index.php">

        <?php else: 
            include 'validation-form/database.php';
            $hash = $_COOKIE['user'];
            $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
            while( $row = mysqli_fetch_assoc($result) ) { 
                $nameC = $row['name'];
                }?>

        <div class="row">
            <div class="col" align="center">
                <h1>Комментарии</h1>
                <form action="validation-form/check_comment.php" method="post">
                <div class="mb-3">
                <label for="comment" class="form-label">Комментарий будет от Вашего имени: <?=$nameC?></label>
                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Ваш комментарий"></textarea><br>
                <button class="btn btn-info" type="submit">Отправить комментарий</button>
                </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

            
            <!--Вывод комментариев с БД-->
            <?php //Вывод БД наоборот        
            $sql = "SELECT * FROM comments ORDER BY id DESC"; 
            $result = $mysql->query($sql);
            
            if ($result->num_rows > 0) {
            //Имя пользователя который оставил комментарий
            while($row = $result->fetch_assoc()) {
                $user_id = $row['user_id'];
                $result2 = $mysql->query("SELECT * FROM `users` WHERE `id`='$user_id'");
                while( $row2 = mysqli_fetch_assoc($result2) ) {
                    $name  = $row2['name']; 
                }?>
                <br><br>
                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">

                <?php //Отредактировано ли сообщение или нет
                if ($row["date_edit"] != ''){ ?>
                    <td bgcolor='#0dd3de' align='left'>Name: <?=$name?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row["date_c"]?> (Edit: <?=$row["date_edit"]?>)</td><tr>
                <?php } else { ?>
                    <td bgcolor='#0dd3de' align='left'>Name: <?=$name?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row["date_c"]?></td><tr>
                <?php }?>
                </table>
                <table border="0" align="center" width="75%" cellpadding="15" bordercolor="Black">
                <td bgcolor='white'><?=$row["comment"]?></td><tr>
                </table>
                
                <?php //Айди авторизированого сейчас пользователя                
                $hash = $_COOKIE['user'];
                $result3 = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
                while( $row3 = mysqli_fetch_assoc($result3) ) {
                    $user_id2  = $row3['id']; 
                }?>
                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">
                <?php if($user_id2 == $row["user_id"]){
                //Комментарий данного авторизированого пользователя ?>                  
                    <td bgcolor='#eb8934' align='right'>
                    <a style="color: Black;" href="validation-form/edit_comment.php?id=<?=$row["id"]?>">Редактировать</a>
                    <a style="color: Black;" href="validation-form/delete_comment.php?id=<?=$row["id"]?>">Удалить</a>
                    </td><tr>
                <?php } else { //Ответить на комментарий?>
                    <td bgcolor='#eb8934' align='right'>
                        <a style="color: Black;" href="validation-form/reply_comment.php?id=<?=$row["id"]?>">Ответить</a>
                <?php } ?>
                </table>
                
                <?php //Выводим ответ на комментарий
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
                    if ($row_reply['id_comment'] == $row["id"]){?> 
                        <br><br><table border="0" align="center" width="67%" cellpadding="7" bordercolor="Black">
                    <?php //Отредактировано ли сообщение или нет
                    if ($row_reply["edit_date_reply"] != ''){?>
                    <td bgcolor='#9bd930' align='left'>&#9989 Name: <?=$name_user_reply?></td>
                    <td bgcolor='#9bd930' align='right'>Time: <?=$row_reply["date_reply"]?> (Edit: <?=$row_reply["edit_date_reply"]?>)</td><tr>
                    <?php } else { ?>
                    <td bgcolor='#9bd930' align='left'>&#9989 Name: <?=$name_user_reply?></td>
                    <td bgcolor='#9bd930' align='right'>Time: <?=$row_reply["date_reply"]?></td><tr>
                    <?php } ?>
                    </table>
                    <table border="0" align="center" width="67%" cellpadding="15" bordercolor="Black">
                    <td bgcolor='white'><?=$row_reply["reply_comment"]?></td><tr>
                    </table>
                    <table border="0" align="center" width="67%" cellpadding="7" bordercolor="Black">

                    <?php if($user_id2 == $row_reply["id_reply_user"]){
                    //Комментарий данного авторизированого пользователя?>

                        <td bgcolor='#eb8934' align='right'>
                        <a style="color: Black;"  href="validation-form/edit_reply_for_comment.php?replyOnCommentId=<?=$row_reply["id_reply"]?>">Редактировать</a>
                        <a style="color: Black;"  href="validation-form/delete_reply_comment.php?idReplyComment=<?=$row_reply["id_reply"]?>">Удалить</a></td><tr>
                    <?php } else { //Ответить на комментарий?>
                    <td bgcolor='#eb8934' align='right'>
                    <a style="color: Black;" href="validation-form/reply_sub_comment.php?id=<?=$row_reply["id_reply"]?>">Ответить</a></td><tr>
                    <?php } ?>
                    </table>
                
                    <?php
                    //******************************************************************
                    //Выводим ответы на под-комментарии
                    //Вывод БД ответы на комменты наоборот        
                    $sqlSubComment = "SELECT * FROM reply_comment ORDER BY id_reply DESC";
                    $resultSubComment = $mysql->query($sqlSubComment);
                    if ($resultSubComment->num_rows > 0) {
                        //Имя пользователя который ответил на комментарий
                        while($rowSubComment = $resultSubComment->fetch_assoc()) {
                        $idUserSubComment = $rowSubComment['id_reply_user'];
                        $resultSubComment2 = $mysql->query("SELECT * FROM `users` WHERE `id`='$idUserSubComment'");
                        while( $rowSubComment2 = mysqli_fetch_assoc($resultSubComment2) ) {
                            $nameUserSubComment  = $rowSubComment2['name']; 
                        }

                        //Проверяем, есть ли ответ на этот комментарий
                        if ($rowSubComment['id_sub_comment'] == $row_reply['id_reply']){ ?>
                        <br><br>
                        <table border="0" align="center" width="60%" cellpadding="7" bordercolor="Black">
                        <?php //Отредактировано ли сообщение или нет
                        if ($rowSubComment["edit_date_reply"] != ''){ ?>
                            <td bgcolor='#d12492' align='left'>&#128293 Name: <?=$nameUserSubComment?></td>
                            <td bgcolor='#d12492' align='right'>Time: <?=$rowSubComment["date_reply"]?> (Edit: <?=$rowSubComment["edit_date_reply"]?>)</td><tr>
                        <?php } else { ?>
                            <td bgcolor='#d12492' align='left'>&#128293 Name: <?=$nameUserSubComment?></td>
                            <td bgcolor='#d12492' align='right'>Time: <?=$rowSubComment["date_reply"]?></td><tr>
                        <?php } ?>

                        <!--Комментарий-->
                        </table>
                        <table border="0" align="center" width="60%" cellpadding="15" bordercolor="Black">
                        <td bgcolor='white'><?=$rowSubComment["reply_comment"]?></td><tr>
                        </table>
                        <table border="0" align="center" width="60%" cellpadding="7" bordercolor="Black">

                        <?php if($user_id2 == $rowSubComment["id_reply_user"]){
                        //Комментарий данного авторизированого пользователя ?>
                            <td bgcolor='#eb8934' align='right'>
                            <a style="color: Black;"  href="validation-form/edit_sub_comment.php?editSubComment=<?=$rowSubComment["id_reply"]?>">Редактировать</a>
                            <a style="color: Black;"  href="validation-form/delete_sub_comment.php?idDeleteSubComment=<?=$rowSubComment["id_reply"]?>">Удалить</a></td><tr>
                        <?php } ?>
                        </table>
                
                <?php } } }
                //******************************************************************
                } } } } }?>
                <br><br>
    <?php $mysql->close();
include 'layouts/footer.php'; ?>