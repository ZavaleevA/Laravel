<?php include 'layouts/header1.php';?>
    <title>Объявления</title>
<?php include 'layouts/header2.php';?>
<?php include 'layouts/navbar1.php'; ?>
    <li><a href="kabinet.php">Личный кабинет</a></li>
    <li><a href="comment.php">Комментарии</a></li>
    <li><a href="" class="current">Объявления</a></li>
    <li><a href="parserForUrl.php">Парсинг</a></li>
    <li><a href="validation-form/exit.php">Выйти</a></li>
<?php include 'layouts/navbar2.php'; ?>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>          

        <meta http-equiv="refresh" content="0; /index.php">

    <?php else: ?>
        
        <?php
            include 'validation-form/database.php';
            $sql = "SELECT * FROM `parse_olx` ORDER BY `parse_olx`.`dates` DESC";
            $result = $mysql->query($sql);
            if ($result->num_rows > 0){
                ?>
                    <br><br>
                <?php
                while($row = $result->fetch_assoc()) {
                    ?>
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
                    <?php
                    $dateAdsDay = date("d",strtotime($row["dates"]));
                    $dateAdsMonth = date("m",strtotime($row["dates"]));
                    $dateAdsYear = date("Y",strtotime($row["dates"]));
                    $dateToday = date('d');
                    if ($dateAdsDay != $dateToday) {
                        $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                        $dateMonthRus = $arr[$dateAdsMonth - 1];
                        $finalDate = $dateAdsDay . " " . $dateMonthRus . " " . $dateAdsYear;
                    } else {
                        $finalDate = "cегодня";
                    }
                    
                    ?>
                    <td bgcolor='white' width="65%" valign="bottom">Опубликовано: <?=$finalDate?></td><tr>
                    </table>
                    <br>

                    <?php
                }
            } else {
                ?>
                <br><br><br>
                <h1 align="center"><strong>Объявлений нет, либо запарсите <a style="color: darkcyan;" href="parserForUrl.php"> тут</strong></h1>
                <?php
            }
            $mysql->close();
        ?>

    <?php endif; ?>    
<?php include 'layouts/footer.php'; ?>