<?php $location  = 'reply_sub_comment'; 
include $_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/layouts/navbar.php'; ?>

    <div class="container mt-4">

    <?php if (!isset($_COOKIE['user'])): ?>
        <meta http-equiv="refresh" content="0; /index.php">
    <?php else: ?>
        <div class="row">
            <div class="col" align="center">
                <h1>Ответить на комментарий:</h1>
                <!--Выводим комментарий на который хотят ответить-->
                <?php //Ищем дату, имя владельца комментария, проверяем редактирован или нет и выводим
                include 'database.php';
                $hash = $_COOKIE['user'];
                $result = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
                while( $row = mysqli_fetch_assoc($result) ) { 
                    $nameC = $row['name'];
                }
                $idSubComment = $_GET['id'];
                $rowReply = $mysql->query("SELECT * FROM `reply_comment` WHERE `id_reply`='$idSubComment'");
                while( $rowEdit = mysqli_fetch_assoc($rowReply) ) {
                    $replyIdSubComment = $rowEdit['id_reply'];
                    $replyIdUser = $rowEdit['id_reply_user']; 
                    $replySubComment = $rowEdit['reply_comment'];
                    $replyDateSubComment = $rowEdit['date_reply'];
                    $replyEditSubComment = $rowEdit['edit_date_reply'];
                    $id_comment = $rowEdit['id_comment'];
                } 

                $resultReplySubComment = $mysql->query("SELECT * FROM `users` WHERE `id`='$replyIdUser'");
                while($rowReplySubComment = mysqli_fetch_assoc($resultReplySubComment)){
                    $userNameReplySubComment  = $rowReplySubComment['name']; 
                }
                //Вывод самого комментария на который хотят ответить ?>
                <br>
                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black"> 
                <?php //Отредактировано ли сообщение или нет
                if ($replyEditSubComment != ''){ ?>
                    <td bgcolor='#0dd3de' align='left'>Name: <?=$userNameReplySubComment?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$replyDateSubComment?> (Edit: <?=$replyEditSubComment?>)</td><tr>
                <?php } else { ?>
                    <td bgcolor='#0dd3de' align='left'>Name: <?=$userNameReplySubComment?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$replyDateSubComment?></td><tr>
                <?php } ?>
                </table>
                <table border="0" align="center" width="75%" cellpadding="15" bordercolor="Black">
                <td bgcolor='white'><?=$replySubComment?></td><tr>
                </table>
                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">
                <td bgcolor='#25ba48' align='right'><a style="color: Black;" href="/comment.php">Отмена</a></td><tr>
                </table> 
                <!--Форма для заполнения ответа на сообщение-->
                <form action="check_reply_sub_comment.php?id=<?=$replyIdSubComment?>" method="post">
                <div class="mb-3"><br>
                <label for="replySubComment" class="form-label">Ответ будет от Вашего имени: <?=$nameC?></label>
                <textarea class="form-control" name="replySubComment" id="replySubComment" rows="3" placeholder="Ваш ответ"></textarea><br>
                <button class="btn btn-info" type="submit">Ответить на комментарий</button>                        
                </form>
                <a href="/comment.php" class="btn btn-warning" >Отмена</a> 
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
            } ?>
            <br><br>
            <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">
            <?php //Отредактировано ли сообщение или нет
            if ($row["date_edit"] != ''){ ?>
                <td bgcolor='#0dd3de' align='left'>Name: <?=$name?></td>
                <td bgcolor='#0dd3de' align='right'>Time: <?=$row["date_c"]?> (Edit: <?=$row["date_edit"]?>)</td><tr>
                <?php } else { ?>
                    <td bgcolor='#0dd3de' align='left'>Name: <?=$name?></td>
                    <td bgcolor='#0dd3de' align='right'>Time: <?=$row["date_c"]?></td><tr>
                <?php } ?>
                </table>
                <table border="0" align="center" width="75%" cellpadding="15" bordercolor="Black">
                <?php if ($id_comment == $row["id"]){ ?>
                    <td bgcolor='adadad'><?=$row["comment"]?></td><tr>
                <?php } else { ?>
                    <td bgcolor='white'><?=$row["comment"]?></td><tr>
                <?php } ?>
                </table>
                <?php //Айди авторизированого сейчас пользователя                
                $hash = $_COOKIE['user'];
                $result3 = $mysql->query("SELECT * FROM `users` WHERE `hash`='$hash'");
                while( $row3 = mysqli_fetch_assoc($result3) ) {
                $user_id2  = $row3['id']; 
                } ?>
                <table border="0" align="center" width="75%" cellpadding="7" bordercolor="Black">
                <?php if($user_id2 == $row["user_id"]){
                //Комментарий данного авторизированого пользователя ?>                  
                    <td bgcolor='#eb8934' align='right'>
                    <a style="color: Black;" href="edit_comment.php?id=<?=$row["id"]?>">Редактировать</a>
                    <a style="color: Black;" href="delete_comment.php?id=<?=$row["id"]?>">Удалить</a>
                    </td><tr>
                <?php } else { //Ответить на комментарий
                    if ($id_comment == $row["id"]){ ?>
                        <td bgcolor='#25ba48' align='right'>
                        <a style="color: Black;" href="/comment.php">Отмена</a>
                    <?php } else { ?>
                        <td bgcolor='#eb8934' align='right'>
                        <a style="color: Black;" href="reply_comment.php?id=<?=$row["id"]?>">Ответить</a>
                    <?php } } ?>
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
                if ($row_reply['id_comment'] == $row["id"]){ ?>
                <br><br>
                <table border="0" align="center" width="67%" cellpadding="7" bordercolor="Black">
                <?php //Отредактировано ли сообщение или нет
                if ($row_reply["edit_date_reply"] != ''){ ?>
                    <td bgcolor='#9bd930' align='left'>&#9989 Name: <?=$name_user_reply?></td>
                    <td bgcolor='#9bd930' align='right'>Time: <?=$row_reply["date_reply"]?> (Edit: <?=$row_reply["edit_date_reply"]?>)</td><tr>
                <?php } else { ?>
                    <td bgcolor='#9bd930' align='left'>&#9989 Name: <?=$name_user_reply?></td>
                    <td bgcolor='#9bd930' align='right'>Time: <?=$row_reply["date_reply"]?></td><tr>
                <?php } ?>
                </table>
                <table border="0" align="center" width="67%" cellpadding="15" bordercolor="Black">
                <?php if ($replyIdSubComment == $row_reply["id_reply"]){ ?>
                    <td bgcolor='adadad'><?=$row_reply["reply_comment"]?></td><tr>
                <?php } else { ?>
                    <td bgcolor='white'><?=$row_reply["reply_comment"]?></td><tr>
                <?php } ?>
                </table>
                <table border="0" align="center" width="67%" cellpadding="7" bordercolor="Black">
                <?php if($user_id2 == $row_reply["id_reply_user"]){
                //Комментарий данного авторизированого пользователя ?>
                    <td bgcolor='#eb8934' align='right'>
                    <a style="color: Black;"  href="edit_reply_for_comment.php?replyOnCommentId=<?=$row_reply["id_reply"]?>">Редактировать</a>
                    <a style="color: Black;"  href="delete_reply_comment.php?idReplyComment=<?=$row_reply["id_reply"]?>">Удалить</a></td><tr>
                <?php } else { //Ответить на комментарий 
                    if ($replyIdSubComment == $row_reply["id_reply"]){ ?>
                        <td bgcolor='#25ba48' align='right'>
                        <a style="color: Black;" href="/comment.php">Отмена</a></td><tr>
                    <?php } else { ?>
                        <td bgcolor='#eb8934' align='right'>
                        <a style="color: Black;" href="reply_sub_comment.php?id=<?=$row_reply["id_reply"]?>">Ответить</a></td><tr>
                    <?php } } ?>
                </table>
                <?php //******************************************************************
                //Выводим ответы на под-комментарии
                //Вывод БД ответы на комменты наоборот        
                $sqlSubComment = "SELECT * FROM reply_comment ORDER BY id_reply DESC"; 
                $resultSubComment = $mysql->query($sqlSubComment);
                if ($resultSubComment->num_rows > 0) {
                    //Имя пользователя который ответил на комментарий
                    while($rowSubComment = $resultSubComment->fetch_assoc()) {
                        $idUserSubComment = $rowSubComment['id_reply_user'];
                        $resultSubComment2 = $mysql->query("SELECT * FROM `users` WHERE `id`='$id_reply_user'");
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
                    <a style="color: Black;"  href="edit_sub_comment.php?editSubComment=<?=$rowSubComment["id_reply"]?>">Редактировать</a>
                    <a style="color: Black;"  href="delete_sub_comment.php?idDeleteSubComment=<?=$rowSubComment["id_reply"]?>">Удалить</a></td><tr>
                <?php } ?>
                </table>
                <?php } } }
                //******************************************************************
                } } } } } ?>
                <br><br>
    <?php $mysql->close();
include $_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php'; ?>