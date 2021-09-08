<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\Http\Requests\ParsingRequest;
use App\Models\Parsing;
use \DB;
use \Auth;

class ParsingController extends Controller
{
    public function newParsing(ParsingRequest $url){
        $url = $url->input('url');
        $html = file_get_contents($url);
        $crawler = new Crawler(null, $url);
        $crawler->addHtmlContent($html, 'UTF-8');

        $links = $crawler->filter('a[class="marginright5 link linkWithHash detailsLink"]')->each(function($node) {
            $href  = $node->attr('href');
            return compact('href');
        });

        foreach($links as $element) {
            $html = file_get_contents($element['href']);
            $crawlerPage = new Crawler(null, $element['href']);
            $crawlerPage->addHtmlContent($html, 'UTF-8');
            $hrefPhoto = $crawlerPage->filter('img[class="css-1bmvjcs"]')->attr('src');
            $title = $crawlerPage->filter('h1')->text();
            $priceWithDollar = $crawlerPage->filter('h3')->text();
            $price = stristr($priceWithDollar, ' $', true);
            if($posSpace = strpos($price, ' ')){
                $priceFirst = stristr($price, ' ', true);
                $priceSecond = substr($price, $posSpace + 1, );
                $price = $priceFirst . $priceSecond;
            }    

            $textАttributeP = $crawlerPage->filter('p[class="css-xl6fe0-Text eu5v0x0"]')->each(function ($node){
                $attributeP = $node->text();
                return compact('attributeP');
            });

            foreach($textАttributeP as $elementАttributeP) {
                 if (stristr($elementАttributeP['attributeP'], 'Год выпуска') == true){
                    $textAndYear = $elementАttributeP['attributeP'];
                    $posYear = strpos($textAndYear, ':');
                    $textYear = substr($textAndYear, $posYear + 2, 5); 
                } elseif (stristr($elementАttributeP['attributeP'], 'Вид топлива') == true){
                    $textAndTypeOfFuel = $elementАttributeP['attributeP'];
                    $posTypeOfFuel = strpos($textAndTypeOfFuel, ':');
                    $textTypeOfFuel = substr($textAndTypeOfFuel, $posTypeOfFuel + 2, );                
                } elseif (stristr($elementАttributeP['attributeP'], 'Пробег') == true){
                    $textAndMileage = $elementАttributeP['attributeP'];
                    $posMileage = strpos($textAndMileage, ':');
                    $textMileageAndKM = substr($textAndMileage, $posMileage + 2, );
                    $posKM = strpos($textMileageAndKM, 'к'); 
                    $textMileage = substr($textMileageAndKM, 0, $posKM - 1);
                    if($posSpace = strpos($textMileage, ' ')){
                        $mileageFirst = stristr($textMileage, ' ', true);
                        $mileageSecond = substr($textMileage, $posSpace + 1, );
                        $textMileage = $mileageFirst . $mileageSecond;
                    }
                }
            }
            
            $description = $crawlerPage->filter('div[class="css-g5mtbi-Text"]')->text();

            // Find publication_date  (дата публикации)
            $publication_date = $crawlerPage->filter('span[class="css-19yf5ek"]')->text();
            //конвертирую в дату для БД, узнаём число месяца 
            $dayOfTheMonth  = stristr($publication_date, ' ', true); 
            if ($dayOfTheMonth != 'Сегодня') {
                // отсекаем всё слева
                $upToAMonth  = strstr($publication_date, ' ');      
                // узнаём сколько знаков до года
                $posMonth = strpos($upToAMonth, "2");   
                // отступим $pos количество символов, и удалим всё справа
                $finalMonth = substr($upToAMonth, 1, $posMonth - 2);
                //отсекаем все после первого пробла       
                $dayDelete = strstr($publication_date, ' ', false); 
                //узнаем сколько знаков до точки
                $posYear = strpos($dayDelete, "."); 
                //отсекаем месяц до года без пробелов на краях
                $monthAndYear = substr($dayDelete, 1, $posYear - 4); 
                //отсекаем год
                $year  = strstr($monthAndYear, ' ', false); 
                //отсекаем пробед перед годом
                $finalYear = substr($year, 1); 

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

            $parsing = new Parsing();
            $parsing->url_ads = $element['href'];
            $parsing->url_image = $hrefPhoto;
            $parsing->title_name = $title;
            $parsing->price = $price;
            $parsing->year = $textYear;
            $parsing->type_of_fuel = $textTypeOfFuel;
            $parsing->mileage = $textMileage;
            $parsing->description = $description;
            $parsing->dates = $finalDate;
            $parsing->updated_at = NULL;
            $parsing->created_at = date('Y-m-d H:i:s');
            $parsing->save();
        }
        return redirect()->back()->with('success', 'Парсинг прошел успешно!');
    }

    public function allDataParsing(){
        $parsing = Parsing::orderBy('dates', 'DESC')->paginate(5);
        return view('ads', ['data' => $parsing]);
    }

    public function dateAds($id){
        $parsing = new Parsing();
        return view('individualAds', ['data' => [$parsing->find($id)]]);
    } 

    public function updateParsing(){
        $url = 'https://www.olx.ua/transport/legkovye-avtomobili/daewoo/lanos-sens/kremenchug/?search%5Bfilter_float_motor_year%3Afrom%5D=2008';
        $html = file_get_contents($url);
        $crawler = new Crawler(null, $url);
        $crawler->addHtmlContent($html, 'UTF-8');

        $links = $crawler->filter('a[class="marginright5 link linkWithHash detailsLink"]')->each(function($node) {
            $href  = $node->attr('href');
            return compact('href');
        });
        $lastDat = DB::table('parsings')->get('dates')->sortByDesc('dates')->first();
        if($lastDat != ''){
            $lastDat = $lastDat->dates;
            $lastYear = stristr($lastDat, '-', true);
            $lastMounthAndDay = strstr($lastDat, '-');
            $lastMounth = substr($lastMounthAndDay, 1, 2);
            $lastDay = substr($lastMounthAndDay, 4, 5);
        } else {
           $lastYear = $lastMounth = $lastDay = 0;
        }
        $newAds = 0;       
        foreach($links as $element) {
            $html = file_get_contents($element['href']);
            $crawlerPage = new Crawler(null, $element['href']);
            $crawlerPage->addHtmlContent($html, 'UTF-8');
            $hrefPhoto = $crawlerPage->filter('img[class="css-1bmvjcs"]')->attr('src');
            $title = $crawlerPage->filter('h1')->text();
            $price = $crawlerPage->filter('h3')->text();
            $textАttributeP = $crawlerPage->filter('p[class="css-xl6fe0-Text eu5v0x0"]')->each(function ($node){
                $attributeP = $node->text();
                return compact('attributeP');
            });

            foreach($textАttributeP as $elementАttributeP) {
                 if (stristr($elementАttributeP['attributeP'], 'Год выпуска') == true){
                    $textYear = $elementАttributeP['attributeP'];                  
                } elseif (stristr($elementАttributeP['attributeP'], 'Вид топлива') == true){
                    $textTypeOfFuel = $elementАttributeP['attributeP'];                
                } elseif (stristr($elementАttributeP['attributeP'], 'Пробег') == true){
                    $textMileage = $elementАttributeP['attributeP'];  
                }
            }
            
            $description = $crawlerPage->filter('div[class="css-g5mtbi-Text"]')->text();

            // Find publication_date  (дата публикации)
            $publication_date = $crawlerPage->filter('span[class="css-19yf5ek"]')->text();
            //конвертирую в дату для БД, узнаём число месяца 
            $dayOfTheMonth  = stristr($publication_date, ' ', true); 
            if ($dayOfTheMonth != 'Сегодня') {
                // отсекаем всё слева
                $upToAMonth  = strstr($publication_date, ' ');      
                // узнаём сколько знаков до года
                $posMonth = strpos($upToAMonth, "2");   
                // отступим $pos количество символов, и удалим всё справа
                $finalMonth = substr($upToAMonth, 1, $posMonth - 2);
                //отсекаем все после первого пробла       
                $dayDelete = strstr($publication_date, ' ', false); 
                //узнаем сколько знаков до точки
                $posYear = strpos($dayDelete, "."); 
                //отсекаем месяц до года без пробелов на краях
                $monthAndYear = substr($dayDelete, 1, $posYear - 4); 
                //отсекаем год
                $year  = strstr($monthAndYear, ' ', false); 
                //отсекаем пробед перед годом
                $finalYear = substr($year, 1); 

                $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                $i = 0;
                while ($finalMonth != $arr[$i]){
                    $i++;
                }
                $i++;
                $finalDate = $finalYear . '-' . $i . '-' . $dayOfTheMonth;
            } else {
                $finalDate = date("Y-m-d");
                $finalYear = date("Y");
                $i = date("m");
                $dayOfTheMonth = date("d");
            }
            if (($finalYear <= $lastYear) AND ($i <= $lastMounth) AND ($dayOfTheMonth <= $lastDay)){
                break;       
            }
            
            $parsing = new Parsing();
            $parsing->url_ads = $element['href'];
            $parsing->url_image = $hrefPhoto;
            $parsing->title_name = $title;
            $parsing->price = $price;
            $parsing->year = $textYear;
            $parsing->type_of_fuel = $textTypeOfFuel;
            $parsing->mileage = $textMileage;
            $parsing->description = $description;
            $parsing->dates = $finalDate;
            $parsing->updated_at = NULL;
            $parsing->created_at = date('Y-m-d H:i:s');
            $parsing->save();
            $newAds++;
        }
        if ($newAds == 0){
            return redirect()->back()->with('primary', '🧐 Новых объявлений нет 🧐');
        } else {
            return redirect()->back()->with('success', 'Обновление прошло успешно! ✅ Новых объявлений добавлено: ' . $newAds . '! ✅');
        }       
    }

    public function filterAds(Request $fullInfo){
        $parsing = Parsing::orderBy('dates', 'DESC');
        if ($priceFrom = $fullInfo->priceFrom) {
            switch($priceFrom) {
                case 1:
                    $parsing = $parsing->where('price', '>=', '1000');
                    break;
                case 2:
                    $parsing = $parsing->where('price', '>=', '2000');
                    break;
                case 3:
                    $parsing = $parsing->where('price', '>=', '3000');
                    break;
                case 4:
                    $parsing = $parsing->where('price', '>=', '4000');
                    break;
            } 
        }
        
        if ($priceBefore = $fullInfo->priceBefore) {
            switch($priceBefore) {
                case 1:
                    $parsing = $parsing->where('price', '<=', '1000');
                    break;
                case 2:
                    $parsing = $parsing->where('price', '<=', '2000');
                    break;
                case 3:
                    $parsing = $parsing->where('price', '<=', '3000');
                    break;
                case 4:
                    $parsing = $parsing->where('price', '<=', '4000');
                    break;
            } 
        }
        
        if ($yearFrom = $fullInfo->yearFrom) {
            switch($yearFrom) {
                case 1:
                    $parsing = $parsing->where('year', '>=', '2000');
                    break;
                case 2:
                    $parsing = $parsing->where('year', '>=', '2005');
                    break;
                case 3:
                    $parsing = $parsing->where('year', '>=', '2010');
                    break;
                case 4:
                    $parsing = $parsing->where('year', '>=', '2015');
                    break;
            } 
        }
        
        if ($yearBefore = $fullInfo->yearBefore) {
            switch($yearBefore) {
                case 1:
                    $parsing = $parsing->where('year', '<=', '2000');
                    break;
                case 2:
                    $parsing = $parsing->where('year', '<=', '2005');
                    break;
                case 3:
                    $parsing = $parsing->where('year', '<=', '2010');
                    break;
                case 4:
                    $parsing = $parsing->where('year', '<=', '2015');
                    break;
            } 
        }
        
        if ($mileageFrom = $fullInfo->mileageFrom) {
            switch($mileageFrom) {
                case 1:
                    $parsing = $parsing->where('mileage', '>=', '50000');
                    break;
                case 2:
                    $parsing = $parsing->where('mileage', '>=', '100000');
                    break;
                case 3:
                    $parsing = $parsing->where('mileage', '>=', '150000');
                    break;
                case 4:
                    $parsing = $parsing->where('mileage', '>=', '200000');
                    break;
            } 
        }
        
        if ($mileageBefore = $fullInfo->mileageBefore) {
            switch($mileageBefore) {
                case 1:
                    $parsing = $parsing->where('mileage', '<=', '100000');
                    break;
                case 2:
                    $parsing = $parsing->where('mileage', '<=', '150000');
                    break;
                case 3:
                    $parsing = $parsing->where('mileage', '<=', '200000');
                    break;
                case 4:
                    $parsing = $parsing->where('mileage', '<=', '250000');
                    break;
            } 
        }
        
        if ($fuel = $fullInfo->fuel) {
            switch($fuel) {
                case 1:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Бензин');
                    break;
                case 2:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Дизель');
                    break;
                case 3:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Газ / бензин');
                    break;
                case 4:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Электро');
                    break;
            } 
        }
        
        $today = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime( "- 1 day" ));
        $lastWeek = date("Y-m-d", strtotime( "- 7 day" ));
        $lastMonth = date("Y-m-d", strtotime( "- 1 month" ));
        if ($publicatedFrom = $fullInfo->publicatedFrom) {
            switch($publicatedFrom) {
                case 1:
                    $parsing = $parsing->where('dates', '>=', $today);
                    break;
                case 2:
                    $parsing = $parsing->where('dates', '>=', $yesterday);
                    break;
                case 3:
                    $parsing = $parsing->where('dates', '>=', $lastWeek);
                    break;
                case 4:
                    $parsing = $parsing->where('dates', '>=', $lastMonth);
                    break;
            } 
        }
        if ($publicatedBefore = $fullInfo->publicatedBefore) {
            switch($publicatedBefore) {
                case 1:
                    $parsing = $parsing->where('dates', '<=', $today);
                    break;
                case 2:
                    $parsing = $parsing->where('dates', '<=', $yesterday);
                    break;
                case 3:
                    $parsing = $parsing->where('dates', '<=', $lastWeek);
                    break;
                case 4:
                    $parsing = $parsing->where('dates', '<=', $lastMonth);
                    break;
            } 
        }
        if ($searchByTitle = $fullInfo->searchByTitle) {
            $parsing = $parsing->where('title_name', '=', $searchByTitle);
        }
        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing]);
    } 
}