<?php
	include_once ( 'simplehtmldom/simple_html_dom.php');
	// Create DOM from URL or file
	$parserUrl = filter_var(trim($_POST['parser']), FILTER_SANITIZE_STRING);
	$html = file_get_html($parserUrl);

	$temporarily = '';
	include ('database.php');
	// Find all links
	foreach($html->find('a') as $element) {
		if (substr($element->href, 0, 32) == 'https://www.olx.ua/d/obyavlenie/') {
				
			$searchRepeat = $mysql->query("SELECT * FROM `parse_olx` WHERE `url_ads`='$element->href'");
			while($rowSearchRepeat = $searchRepeat->fetch_assoc()){
				$temporarily = $rowSearchRepeat['url_ads'];
			}
			
			//Добавляем данные, если их нет еще по этой ссылке
			if ($temporarily != $element->href){
				
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

    			$mysql->query("INSERT INTO `parse_olx` (`url_ads`, `url_image`, `title_name`, `price`, `year`, `type_of_fuel`, `mileage`, `description`, `date`) VALUES('$hrefUrl', '$hrefPhoto', '$h1', '$textH3',  '$textYear', '$textTypeOfFuel', '$textMileage','$div', '$span')");
			}
		}
	}
	
	$mysql->close();
	header('Location: /parserForUrl.php');
?>