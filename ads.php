<?php $location  = 'ads';
include 'layouts/header.php';
include 'layouts/navbar.php'; ?>

    <div class="container mt-4">

        <?php if (!isset($_COOKIE['user'])): ?>          

        <meta http-equiv="refresh" content="0; /index.php">

    <?php else: 
        include 'validation-form/database.php';
        $sql = "SELECT * FROM `parse_olx` ORDER BY `parse_olx`.`dates` DESC";
        $result = $mysql->query($sql);
        if ($result->num_rows > 0){ ?>
            <br><br>
            <?php while($row = $result->fetch_assoc()) { ?>
                <table border="0" align="center" width="100%" cellpadding="7" bordercolor="Black">
                <td bgcolor='white' rowspan="2" width="25%" align='fleft'>
                    <a style="color: Black;" href="validation-form/description.php?id=<?=$row["id"]?>">
                        <img style="width: 100%; height: 100%;" src="<?=$row["url_image"]?>">
                    </a>
                </td>
                <td bgcolor='white' width="65%" valign="top">
                    <h3>
                    <a style="color: Black;" href="validation-form/description.php?id=<?=$row["id"]?>">
                    <strong><?=$row["title_name"]?></strong>
                    </a>
                    </h3>
                </td>
                <td bgcolor='white' rowspan="2" width="10%" valign="top"><h3><strong><?=$row["price"]?></strong></h3></td><tr>

                <?php $dateAds = date("d m Y",strtotime($row["dates"]));
                      $dateAdsDay = date("d",strtotime($row["dates"]));
                      $dateAdsMonth = date("m",strtotime($row["dates"]));
                      $dateAdsYear = date("Y",strtotime($row["dates"]));
                      $dateToday = date('d m Y');
                    
                    if ($dateAds != $dateToday) {
                        $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                        $dateMonthRus = $arr[$dateAdsMonth - 1];
                        $finalDate = $dateAdsDay . " " . $dateMonthRus . " " . $dateAdsYear;
                    } else {
                        $finalDate = "cегодня";
                    }?>
                    <td bgcolor='white' width="65%" valign="bottom">Опубликовано: <?=$finalDate?></td><tr>
                    </table>
                    <br>
                <?php } } else { ?>
                <br><br><br>
                <h1 align="center"><strong>Объявлений нет, либо запарсите <a style="color: darkcyan;" href="parser_for_url.php"> тут</strong></h1>
                <?php } $mysql->close(); 
    endif;   
include 'layouts/footer.php'; ?>