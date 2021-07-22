<?php 
 switch($location){
    case 'kabinet':
        $content = '1';
        break;
    case 'ads':
        $content = '1';
        break;
    case 'comment':
        $content = '1';
        break;
    case 'index':
        $content = '1';
        break;
    case 'parser_for_url':
        $content = '1';
        break;
    case 'reg':
        $content = '1';
        break;
    case 'edit_reply_for_comment':
        $content = '0';
        break;
    case 'edit_sub_comment':
        $content = '0';
        break;
    case 'loading':
        $content = '0';
        break;
    case 'reply_comment':
        $content = '0';
        break;
    case 'reply_sub_comment':
        $content = '0';
        break;
    case 'description':
        $content = '0';
        break;
    case 'edit_comment':
        $content = '0';
        break; 
}
?>

<body>
    <nav class="top-menu">
        <ul class="menu-main">

            <?php if (!isset($_COOKIE['user'])): ?>
                <li><a href="kabinet.php">Личный кабинет</a></li>
                <li><a href="comment.php">Комментарии</a></li>
                <li><a href="ads.php">Объявления</a></li>
                <li><a href="parser_for_url.php">Парсинг</a></li>
                <li><a href="reg.php">Зарегистрироваться</a></li>
                <li><a href="index.php">Войти</a></li>

            <?php else: 
                if ($content == '1'){ 
                    ?>
                    <li><a href="kabinet.php">Личный кабинет</a></li>
                    <li><a href="comment.php">Комментарии</a></li>
                    <li><a href="ads.php">Объявления</a></li>
                    <li><a href="parser_for_url.php">Парсинг</a></li>
                    <li><a href="validation-form/exit.php">Выйти</a></li>
                    <?php 
                } else { 
                    ?>
                    <li><a href="/kabinet.php">Личный кабинет</a></li>
                    <li><a href="/comment.php">Комментарии</a></li>
                    <li><a href="/ads.php">Объявления</a></li>
                    <li><a href="/parser_for_url.php">Парсинг</a></li>
                    <li><a href="exit.php">Выйти</a></li>
                    <?php
                }
                endif; ?>
        </ul>
    </nav>   