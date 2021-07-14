<?php include 'layouts/header1.php';?>
    <title>Парсинг</title>
<?php include 'layouts/header2.php';?>
<?php include 'layouts/navbar1.php'; ?>
    <li><a href="kabinet.php">Личный кабинет</a></li>
    <li><a href="comment.php">Комментарии</a></li>
    <li><a href="" class="current">Парсинг</a></li>
    <li><a href="validation-form/exit.php">Выйти</a></li>
<?php include 'layouts/navbar2.php'; ?>

    <div class="container mt-4">

        <?php
            if (!isset($_COOKIE['user'])):
        ?>
            <meta http-equiv="refresh" content="0;/index.php">
            <?php else: ?>
            
            <div class="row">
            <div class="col" align="center">
                <h1>Форма для ссылки парсинга</h1>
                <form action="validation-form/parser.php" method="post">
                <input type="text" class="form-control" name="parser" id="parser" placeholder="Вставьте ссылку"><br>
                <button class="btn btn-success" type="submit">Получить данные</button>
                </form>
                </form>
            </div>

    <?php endif; ?>
        </div>
<?php include 'layouts/footer.php'; ?>