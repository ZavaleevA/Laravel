<?php $location  = 'parser_for_url';
include 'layouts/header.php';
include 'layouts/navbar.php'; ?>

    <div class="container mt-4">

        <?php if (!isset($_COOKIE['user'])): ?>
            <meta http-equiv="refresh" content="0;/index.php">
            
        <?php else: $urlWebsite = 'https://www.olx.ua/transport/legkovye-avtomobili/daewoo/lanos-sens/kremenchug/?search%5Bfilter_float_motor_year%3Afrom%5D=2008'; ?>

            <div class="row">
                <div class="col" align="center">
                    <h1>Форма для обновления парсинга</h1>
                    <form action="validation-form/update_parser.php?parserUrl=<?=$urlWebsite?>" method="post">                
                    <button class="btn btn-success" type="submit">Обновить данные</button>
                    </form>
                </div>
            </div>
        <?php endif; 
include 'layouts/footer.php'; ?>