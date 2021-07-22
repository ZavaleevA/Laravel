<?php 
 switch($location){
    case 'kabinet':
        $title = 'Личный кабинет';
        break;
    case 'ads':
        $title = 'Объявления';
        break;
    case 'comment':
        $title = 'Комментарии';
        break;
    case 'index':
        $title = 'Форма авторизации';
        break;
    case 'parser_for_url':
        $title = 'Парсинг';
        break;
    case 'reg':
        $title = 'Форма регистрации';
        break;
    case 'edit_reply_for_comment':
        $title = 'Редактировать комментарий';
        break;
    case 'edit_sub_comment':
        $title = 'Редактировать комментарий';
        break;
    case 'loading':
        $title = 'Загрузить изображение';
        break;
    case 'reply_comment':
        $title = 'Ответить на комментарий';
        break;
    case 'reply_sub_comment':
        $title = 'Ответить на под-комментарий';
        break;
    case 'description':
        $title = $titleName;
        break;
    case 'edit_comment':
        $title = 'Редактировать комментарий';
        break;  
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title><?=$title?></title>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/navigation.css">
<style>
body { background: url(/photo/grad1.jpg); 
        background-attachment: fixed;}
</style>
</head>