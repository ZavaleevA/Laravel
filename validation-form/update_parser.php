<?php
	include_once ( 'simplehtmldom/simple_html_dom.php');
	// Create DOM from URL or file
	$parserUrl = $_GET['parserUrl'];
	$html = file_get_html($parserUrl);
	
	$temporarily = '';
	include ('database.php');

	$searchRepeat = $mysql->query("SELECT * FROM `parse_olx` ORDER BY `parse_olx`.`dates` DESC");
	$rowSearchRepeat = $searchRepeat->fetch_assoc();
	$dates = $rowSearchRepeat['dates'];

	// Find all links
	foreach($html->find('a') as $element) {
		if (substr($element->href, 0, 32) == 'https://www.olx.ua/d/obyavlenie/') {
			$searchRepeat = $mysql->query("SELECT * FROM `parse_olx` WHERE `url_ads`='$element->href'");
			while($rowSearchRepeat = $searchRepeat->fetch_assoc()){
				$temporarily = $rowSearchRepeat['url_ads'];
			}
			$hrefUrl = $element->href;
			$htmlAds = file_get_html($element->href);
			// Find span (дата публикации)
			$span = $htmlAds->find('span[data-cy="ad-posted-at"]', 0)->text();

			//конвертирую в дату для БД
    		$dayOfTheMonth  = stristr($span, ' ', true); // узнаём число месяца

    		if ($dayOfTheMonth != 'Сегодня') {
    			$upToAMonth  = strstr($span, ' ');      // отсекаем всё слева
				$posMonth = strpos($upToAMonth, "2");   // узнаём сколько знаков до года
				$finalMonth = substr($upToAMonth, 1, $posMonth - 2);   // отступим $pos количество символов, и удалим всё справа	

				$dayDelete = strstr($span, ' ', false); //отсекаем все после первого пробла
				$posYear = strpos($dayDelete, "."); //узнаем сколько знаков до точки
				$monthAndYear = substr($dayDelete, 1, $posYear - 4); //отсекаем месяц до года без пробелов на краях
				$year  = strstr($monthAndYear, ' ', false); //отсекаем год
				$finalYear = substr($year, 1); //отсекаем пробед перед годом

				$arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
				$i = 0;
				while ($finalMonth != $arr[$i]){
					$i++;
				}
				$i++;
				$finalDate = $finalYear . '-' . $i . '-' . $dayOfTheMonth;
    			} else {
    				$finalDate = date("Y-m-d");
    			}
    		if ((strtotime($dates) < strtotime($finalDate)) OR (strtotime($dates) == strtotime($finalDate))){		
			//Добавляем данные, если их нет еще по этой ссылке
			if ($temporarily != $hrefUrl){
				
				$htmlAds = file_get_html($element->href);
				$hrefUrl = $element->href;

				// Find all images
				$hrefPhoto = $htmlAds->find('img', 0)->src;
		
    			// Find h1
    			$h1 = $htmlAds->find('h1', 0)->text();
    			
    			// Find h3
    			$textH3 = $htmlAds->find('h3[class="css-8kqr5l-Text eu5v0x0"]', 0)->text();
    			
    			// Find div (описание)
    			$div = addslashes ($htmlAds->find('div[class="css-g5mtbi-Text"]', 0)->text());
    			
				// Find span (дата публикации)
				$span = $htmlAds->find('span[data-cy="ad-posted-at"]', 0)->text();
				//конвертирую в дату для БД
    			$dayOfTheMonth  = stristr($span, ' ', true); // узнаём число месяца

    			if ($dayOfTheMonth != 'Сегодня') {
    				$upToAMonth  = strstr($span, ' ');      // отсекаем всё слева
					$posMonth = strpos($upToAMonth, "2");   // узнаём сколько знаков до года
					$finalMonth = substr($upToAMonth, 1, $posMonth - 2);   // отступим $pos количество символов, и удалим всё справа	

					$dayDelete = strstr($span, ' ', false); //отсекаем все после первого пробла
					$posYear = strpos($dayDelete, "."); //узнаем сколько знаков до точки
					$monthAndYear = substr($dayDelete, 1, $posYear - 4); //отсекаем месяц до года без пробелов на краях
					$year  = strstr($monthAndYear, ' ', false); //отсекаем год
					$finalYear = substr($year, 1); //отсекаем пробед перед годом

					$arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
					$i = 0;
					while ($finalMonth != $arr[$i]){
						$i++;
					}
					$i++;
					$finalDate = $finalYear . '-' . $i . '-' . $dayOfTheMonth;
    			} else {
    				$finalDate = date("Y-m-d");
    			}
    			
    			//Find p (Год выпуска, Вид топлива, Пробег)
    			foreach($htmlAds->find('p[class="css-xl6fe0-Text eu5v0x0"]') as $elementP){
    				$text = $elementP->text();
    				if ($text == stristr($text, 'Год выпуска')) {
    					$textYear = $text;
    				} elseif ($text == stristr($text, 'Вид топлива')) {
    					$textTypeOfFuel = $text;
    				} elseif ($text == stristr($text, 'Пробег')) {
    					$textMileage = $text;
    				}
    			}
    			$mysql->query("INSERT INTO `parse_olx` (`url_ads`, `url_image`, `title_name`, `price`, `year`, `type_of_fuel`, `mileage`, `description`, `dates`) VALUES('$hrefUrl', '$hrefPhoto', '$h1', '$textH3',  '$textYear', '$textTypeOfFuel', '$textMileage','$div', '$finalDate')");
			}
			}
		}
	}
	
	$mysql->close();
	header('Location: /parser_for_url.php');
?>