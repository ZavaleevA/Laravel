<?php
    include 'database.php';
    $idAds = $_GET['id'];
    $result = $mysql->query("SELECT * FROM `parse_olx` WHERE `id`='$idAds'");
    while($row = mysqli_fetch_assoc($result)) {
        $urlImage = $row["url_image"];
        $dates = $row["dates"];
        $titleName = $row["title_name"];
        $price = $row["price"];
        $year = $row["year"];
        $mileage = $row["mileage"];
        $typeOfFuel = $row["type_of_fuel"];
        $description = $row["description"];
    }
    $mysql->close();

 $location  = 'description';    
 include $_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php';
 include $_SERVER['DOCUMENT_ROOT'] . '/layouts/navbar.php'; ?>

<div class="container mt-4">

    <?php if (!isset($_COOKIE['user'])): ?>          
        <meta http-equiv="refresh" content="0; /index.php">
    <?php else: ?>
        <table border="0" align="center" width="100%" cellpadding="7" bordercolor="Black">
        <td bgcolor='white' align='center'>
        <img style="width: 100%; height: 100%;" src="<?=$urlImage?>">
        </td><tr>
        </table><br> 
        <table border="0" align="center" width="100%" cellpadding="7" bordercolor="Black">
        <td bgcolor='white' rowspan="5" width="5%" valign="top"></td>
        <?php $dateAdsDay = date("d",strtotime($dates));
            $dateAdsMonth = date("m",strtotime($dates));
            $dateAdsYear = date("Y",strtotime($dates));
            $dateToday = date('d');
            if ($dateAdsDay != $dateToday) {
                $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                $dateMonthRus = $arr[$dateAdsMonth - 1];
                $finalDate = $dateAdsDay . " " . $dateMonthRus . " " . $dateAdsYear;
            } else {
                $finalDate = "cегодня";
            } ?>  
        <td bgcolor='white' valign="top"><br>Опубликовано: <?=$finalDate?></td>
        <td bgcolor='white' rowspan="5" width="5%" valign="top"></td><tr>
        <td bgcolor='white' valign="top"><h2><?=$titleName?></h2></td><tr>
        <td bgcolor='white' valign="top"><h3><strong><?=$price?></strong></h3></td><tr>
        <td bgcolor='white' valign="top"><h4><?=$year?><br><?=$typeOfFuel?><br><?=$mileage?></h4></td><tr>
        <td bgcolor='white' valign="top"><h2><strong>Описание</strong></h2><h4><?=$description?></h4><br></td><tr>
        </table>
        <br><br><br>
    <?php endif; 
include $_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php'; ?>