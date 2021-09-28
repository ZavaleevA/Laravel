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
        $settingsFilter = "default";
        return view('ads', ['data' => $parsing, 'settingsFilter' => [$settingsFilter]]);
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

        $fullInfoNew['priceFrom'] = $fullInfo->priceFrom;
        $fullInfoNew['priceBefore'] = $fullInfo->priceBefore;
        $fullInfoNew['yearFrom'] = $fullInfo->yearFrom;
        $fullInfoNew['yearBefore'] = $fullInfo->yearBefore;
        $fullInfoNew['mileageFrom'] = $fullInfo->mileageFrom;
        $fullInfoNew['mileageBefore'] = $fullInfo->mileageBefore;
        $fullInfoNew['fuel'] = $fullInfo->fuel;
        $fullInfoNew['publicatedFrom'] = $fullInfo->publicatedFrom;
        $fullInfoNew['publicatedBefore'] = $fullInfo->publicatedBefore;
        $fullInfoNew['searchByTitle'] = $fullInfo->searchByTitle;

        $returnInfo = self::filterDataProcessing($fullInfoNew, $parsing);
        $parsing = $returnInfo['parsing'];
        $settingsFilter = $returnInfo['settingsFilter'];
        
        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function sortByDate($specialToken){
        $parsing = Parsing::orderBy('dates', 'DESC');
        if ($specialToken == "default" || $specialToken == "0 0 0 0 0 0 0 0 0") {
            $settingsFilter = "default";
        } else {
            $settingsFilterWithFull = self::readSpecialToken($specialToken);
            $returnInfo = self::filterDataProcessing($settingsFilterWithFull, $parsing);
            $parsing = $returnInfo['parsing'];
            $settingsFilter = $returnInfo['settingsFilter'];
        }       

        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function sortFromDear($specialToken){
        $parsing = Parsing::orderBy('price', 'DESC');
        if ($specialToken == "default" || $specialToken == "0 0 0 0 0 0 0 0 0") {
            $settingsFilter = "default";
        } else {
            $settingsFilterWithFull = self::readSpecialToken($specialToken);
            $returnInfo = self::filterDataProcessing($settingsFilterWithFull, $parsing);
            $parsing = $returnInfo['parsing'];
            $settingsFilter = $returnInfo['settingsFilter'];
        }       

        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function sortFromCheap($specialToken){
        $parsing = Parsing::orderBy('price', 'ASC');
        if ($specialToken == "default" || $specialToken == "0 0 0 0 0 0 0 0 0") {
            $settingsFilter = "default";
        } else {
            $settingsFilterWithFull = self::readSpecialToken($specialToken);
            $returnInfo = self::filterDataProcessing($settingsFilterWithFull, $parsing);
            $parsing = $returnInfo['parsing'];
            $settingsFilter = $returnInfo['settingsFilter'];
        }       

        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function sortFromNew($specialToken){
        $parsing = Parsing::orderBy('year', 'DESC');
        if ($specialToken == "default" || $specialToken == "0 0 0 0 0 0 0 0 0") {
            $settingsFilter = "default";
        } else {
            $settingsFilterWithFull = self::readSpecialToken($specialToken);
            $returnInfo = self::filterDataProcessing($settingsFilterWithFull, $parsing);
            $parsing = $returnInfo['parsing'];
            $settingsFilter = $returnInfo['settingsFilter'];
        }       

        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function sortFromOld($specialToken){
        $parsing = Parsing::orderBy('year', 'ASC');
        if ($specialToken == "default" || $specialToken == "0 0 0 0 0 0 0 0 0") {
            $settingsFilter = "default";
        } else {
            $settingsFilterWithFull = self::readSpecialToken($specialToken);
            $returnInfo = self::filterDataProcessing($settingsFilterWithFull, $parsing);
            $parsing = $returnInfo['parsing'];
            $settingsFilter = $returnInfo['settingsFilter'];
        }       

        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function sortByMileage($specialToken){
        $parsing = Parsing::orderBy('mileage', 'ASC');
        if ($specialToken == "default" || $specialToken == "0 0 0 0 0 0 0 0 0") {
            $settingsFilter = "default";
        } else {
            $settingsFilterWithFull = self::readSpecialToken($specialToken);
            $returnInfo = self::filterDataProcessing($settingsFilterWithFull, $parsing);
            $parsing = $returnInfo['parsing'];
            $settingsFilter = $returnInfo['settingsFilter'];
        }       

        $parsing = $parsing->paginate(5);
        return view('ads', ['data' => $parsing,'settingsFilter' => [$settingsFilter]]); 
    }

    public function readSpecialToken($specialToken){
        $fullInfo['priceFrom'] = substr($specialToken, 0, 1);
        $fullInfo['priceBefore'] = substr($specialToken, 2, 1);
        $fullInfo['yearFrom'] = substr($specialToken, 4, 1);
        $fullInfo['yearBefore'] = substr($specialToken, 6, 1);
        $fullInfo['mileageFrom'] = substr($specialToken, 8, 1);
        $fullInfo['mileageBefore'] = substr($specialToken, 10, 1);
        $fullInfo['fuel'] = substr($specialToken, 12, 1);
        $fullInfo['publicatedFrom'] = substr($specialToken, 14, 1);
        $fullInfo['publicatedBefore'] = substr($specialToken, 16, 1);
        $fullInfo['searchByTitle'] = substr($specialToken, 18, );
        return $fullInfo;
    }

    public function filterDataProcessing($fullInfo, $parsing){
        $settingsFilter['specialToken'] = ""; 
        if ($priceFrom = $fullInfo['priceFrom']) {
            switch($priceFrom) {
                case 1:
                    $parsing = $parsing->where('price', '>=', '1000');
                    $settingsFilter['priceFrom1'] = "selected";
                    $settingsFilter['priceFrom2'] = "";
                    $settingsFilter['priceFrom3'] = "";
                    $settingsFilter['priceFrom4'] = "";
                    $settingsFilter['specialToken'] = "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('price', '>=', '2000');
                    $settingsFilter['priceFrom1'] = "";
                    $settingsFilter['priceFrom2'] = "selected";
                    $settingsFilter['priceFrom3'] = "";
                    $settingsFilter['priceFrom4'] = "";
                    $settingsFilter['specialToken'] = "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('price', '>=', '3000');
                    $settingsFilter['priceFrom1'] = "";
                    $settingsFilter['priceFrom2'] = "";
                    $settingsFilter['priceFrom3'] = "selected";
                    $settingsFilter['priceFrom4'] = "";
                    $settingsFilter['specialToken'] = "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('price', '>=', '4000');
                    $settingsFilter['priceFrom1'] = "";
                    $settingsFilter['priceFrom2'] = "";
                    $settingsFilter['priceFrom3'] = "";
                    $settingsFilter['priceFrom4'] = "selected";
                    $settingsFilter['specialToken'] = "4 ";
                    break;
            }
        } else {
            $settingsFilter['priceFrom1'] = "";
            $settingsFilter['priceFrom2'] = "";
            $settingsFilter['priceFrom3'] = "";
            $settingsFilter['priceFrom4'] = "";
            $settingsFilter['specialToken'] = "0 ";
        }

        if ($priceBefore = $fullInfo['priceBefore']) {
            switch($priceBefore) {
                case 1:
                    $parsing = $parsing->where('price', '<=', '1000');
                    $settingsFilter['priceBefore1'] = "selected";
                    $settingsFilter['priceBefore2'] = "";
                    $settingsFilter['priceBefore3'] = "";
                    $settingsFilter['priceBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('price', '<=', '2000');
                    $settingsFilter['priceBefore1'] = "";
                    $settingsFilter['priceBefore2'] = "selected";
                    $settingsFilter['priceBefore3'] = "";
                    $settingsFilter['priceBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('price', '<=', '3000');
                    $settingsFilter['priceBefore1'] = "";
                    $settingsFilter['priceBefore2'] = "";
                    $settingsFilter['priceBefore3'] = "selected";
                    $settingsFilter['priceBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('price', '<=', '4000');
                    $settingsFilter['priceBefore1'] = "";
                    $settingsFilter['priceBefore2'] = "";
                    $settingsFilter['priceBefore3'] = "";
                    $settingsFilter['priceBefore4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            }
        } else {
            $settingsFilter['priceBefore1'] = "";
            $settingsFilter['priceBefore2'] = "";
            $settingsFilter['priceBefore3'] = "";
            $settingsFilter['priceBefore4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }

        if ($yearFrom = $fullInfo['yearFrom']) {
            switch($yearFrom) {
                case 1:
                    $parsing = $parsing->where('year', '>=', '2000');
                    $settingsFilter['yearFrom1'] = "selected";
                    $settingsFilter['yearFrom2'] = "";
                    $settingsFilter['yearFrom3'] = "";
                    $settingsFilter['yearFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('year', '>=', '2005');
                    $settingsFilter['yearFrom1'] = "";
                    $settingsFilter['yearFrom2'] = "selected";
                    $settingsFilter['yearFrom3'] = "";
                    $settingsFilter['yearFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('year', '>=', '2010');
                    $settingsFilter['yearFrom1'] = "";
                    $settingsFilter['yearFrom2'] = "";
                    $settingsFilter['yearFrom3'] = "selected";
                    $settingsFilter['yearFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('year', '>=', '2015');
                    $settingsFilter['yearFrom1'] = "";
                    $settingsFilter['yearFrom2'] = "";
                    $settingsFilter['yearFrom3'] = "";
                    $settingsFilter['yearFrom4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['yearFrom1'] = "";
            $settingsFilter['yearFrom2'] = "";
            $settingsFilter['yearFrom3'] = "";
            $settingsFilter['yearFrom4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }
        
        if ($yearBefore = $fullInfo['yearBefore']) {
            switch($yearBefore) {
                case 1:
                    $parsing = $parsing->where('year', '<=', '2000');
                    $settingsFilter['yearBefore1'] = "selected";
                    $settingsFilter['yearBefore2'] = "";
                    $settingsFilter['yearBefore3'] = "";
                    $settingsFilter['yearBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('year', '<=', '2005');
                    $settingsFilter['yearBefore1'] = "";
                    $settingsFilter['yearBefore2'] = "selected";
                    $settingsFilter['yearBefore3'] = "";
                    $settingsFilter['yearBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('year', '<=', '2010');
                    $settingsFilter['yearBefore1'] = "";
                    $settingsFilter['yearBefore2'] = "";
                    $settingsFilter['yearBefore3'] = "selected";
                    $settingsFilter['yearBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('year', '<=', '2015');
                    $settingsFilter['yearBefore1'] = "";
                    $settingsFilter['yearBefore2'] = "";
                    $settingsFilter['yearBefore3'] = "";
                    $settingsFilter['yearBefore4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['yearBefore1'] = "";
            $settingsFilter['yearBefore2'] = "";
            $settingsFilter['yearBefore3'] = "";
            $settingsFilter['yearBefore4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }
        
        if ($mileageFrom = $fullInfo['mileageFrom']) {
            switch($mileageFrom) {
                case 1:
                    $parsing = $parsing->where('mileage', '>=', '50000');
                    $settingsFilter['mileageFrom1'] = "selected";
                    $settingsFilter['mileageFrom2'] = "";
                    $settingsFilter['mileageFrom3'] = "";
                    $settingsFilter['mileageFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('mileage', '>=', '100000');
                    $settingsFilter['mileageFrom1'] = "";
                    $settingsFilter['mileageFrom2'] = "selected";
                    $settingsFilter['mileageFrom3'] = "";
                    $settingsFilter['mileageFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('mileage', '>=', '150000');
                    $settingsFilter['mileageFrom1'] = "";
                    $settingsFilter['mileageFrom2'] = "";
                    $settingsFilter['mileageFrom3'] = "selected";
                    $settingsFilter['mileageFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('mileage', '>=', '200000');
                    $settingsFilter['mileageFrom1'] = "";
                    $settingsFilter['mileageFrom2'] = "";
                    $settingsFilter['mileageFrom3'] = "";
                    $settingsFilter['mileageFrom4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['mileageFrom1'] = "";
            $settingsFilter['mileageFrom2'] = "";
            $settingsFilter['mileageFrom3'] = "";
            $settingsFilter['mileageFrom4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }
        
        if ($mileageBefore = $fullInfo['mileageBefore']) {
            switch($mileageBefore) {
                case 1:
                    $parsing = $parsing->where('mileage', '<=', '100000');
                    $settingsFilter['mileageBefore1'] = "selected";
                    $settingsFilter['mileageBefore2'] = "";
                    $settingsFilter['mileageBefore3'] = "";
                    $settingsFilter['mileageBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('mileage', '<=', '150000');
                    $settingsFilter['mileageBefore1'] = "";
                    $settingsFilter['mileageBefore2'] = "selected";
                    $settingsFilter['mileageBefore3'] = "";
                    $settingsFilter['mileageBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('mileage', '<=', '200000');
                    $settingsFilter['mileageBefore1'] = "";
                    $settingsFilter['mileageBefore2'] = "";
                    $settingsFilter['mileageBefore3'] = "selected";
                    $settingsFilter['mileageBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('mileage', '<=', '250000');
                    $settingsFilter['mileageBefore1'] = "";
                    $settingsFilter['mileageBefore2'] = "";
                    $settingsFilter['mileageBefore3'] = "";
                    $settingsFilter['mileageBefore4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['mileageBefore1'] = "";
            $settingsFilter['mileageBefore2'] = "";
            $settingsFilter['mileageBefore3'] = "";
            $settingsFilter['mileageBefore4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }
        
        if ($fuel = $fullInfo['fuel']) {
            switch($fuel) {
                case 1:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Бензин');
                    $settingsFilter['fuel1'] = "selected";
                    $settingsFilter['fuel2'] = "";
                    $settingsFilter['fuel3'] = "";
                    $settingsFilter['fuel4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Дизель');
                    $settingsFilter['fuel1'] = "";
                    $settingsFilter['fuel2'] = "selected";
                    $settingsFilter['fuel3'] = "";
                    $settingsFilter['fuel4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Газ / бензин');
                    $settingsFilter['fuel1'] = "";
                    $settingsFilter['fuel2'] = "";
                    $settingsFilter['fuel3'] = "selected";
                    $settingsFilter['fuel4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('type_of_fuel', '=', 'Электро');
                    $settingsFilter['fuel1'] = "";
                    $settingsFilter['fuel2'] = "";
                    $settingsFilter['fuel3'] = "";
                    $settingsFilter['fuel4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['fuel1'] = "";
            $settingsFilter['fuel2'] = "";
            $settingsFilter['fuel3'] = "";
            $settingsFilter['fuel4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }
        
        $today = date("Y-m-d");
        $yesterday = date("Y-m-d", strtotime( "- 1 day" ));
        $lastWeek = date("Y-m-d", strtotime( "- 7 day" ));
        $lastMonth = date("Y-m-d", strtotime( "- 1 month" ));

        if ($publicatedFrom = $fullInfo['publicatedFrom']) {
            switch($publicatedFrom) {
                case 1:
                    $parsing = $parsing->where('dates', '>=', $today);
                    $settingsFilter['publicatedFrom1'] = "selected";
                    $settingsFilter['publicatedFrom2'] = "";
                    $settingsFilter['publicatedFrom3'] = "";
                    $settingsFilter['publicatedFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('dates', '>=', $yesterday);
                    $settingsFilter['publicatedFrom1'] = "";
                    $settingsFilter['publicatedFrom2'] = "selected";
                    $settingsFilter['publicatedFrom3'] = "";
                    $settingsFilter['publicatedFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('dates', '>=', $lastWeek);
                    $settingsFilter['publicatedFrom1'] = "";
                    $settingsFilter['publicatedFrom2'] = "";
                    $settingsFilter['publicatedFrom3'] = "selected";
                    $settingsFilter['publicatedFrom4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('dates', '>=', $lastMonth);
                    $settingsFilter['publicatedFrom1'] = "";
                    $settingsFilter['publicatedFrom2'] = "";
                    $settingsFilter['publicatedFrom3'] = "";
                    $settingsFilter['publicatedFrom4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['publicatedFrom1'] = "";
            $settingsFilter['publicatedFrom2'] = "";
            $settingsFilter['publicatedFrom3'] = "";
            $settingsFilter['publicatedFrom4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }

        if ($publicatedBefore = $fullInfo['publicatedBefore']) {
            switch($publicatedBefore) {
                case 1:
                    $parsing = $parsing->where('dates', '<=', $today);
                    $settingsFilter['publicatedBefore1'] = "selected";
                    $settingsFilter['publicatedBefore2'] = "";
                    $settingsFilter['publicatedBefore3'] = "";
                    $settingsFilter['publicatedBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "1 ";
                    break;
                case 2:
                    $parsing = $parsing->where('dates', '<=', $yesterday);
                    $settingsFilter['publicatedBefore1'] = "";
                    $settingsFilter['publicatedBefore2'] = "selected";
                    $settingsFilter['publicatedBefore3'] = "";
                    $settingsFilter['publicatedBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "2 ";
                    break;
                case 3:
                    $parsing = $parsing->where('dates', '<=', $lastWeek);
                    $settingsFilter['publicatedBefore1'] = "";
                    $settingsFilter['publicatedBefore2'] = "";
                    $settingsFilter['publicatedBefore3'] = "selected";
                    $settingsFilter['publicatedBefore4'] = "";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "3 ";
                    break;
                case 4:
                    $parsing = $parsing->where('dates', '<=', $lastMonth);
                    $settingsFilter['publicatedBefore1'] = "";
                    $settingsFilter['publicatedBefore2'] = "";
                    $settingsFilter['publicatedBefore3'] = "";
                    $settingsFilter['publicatedBefore4'] = "selected";
                    $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "4 ";
                    break;
            } 
        } else {
            $settingsFilter['publicatedBefore1'] = "";
            $settingsFilter['publicatedBefore2'] = "";
            $settingsFilter['publicatedBefore3'] = "";
            $settingsFilter['publicatedBefore4'] = "";
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . "0 ";
        }

        if ($searchByTitle = $fullInfo['searchByTitle']) {
            $parsing = $parsing->where('title_name', '=', $searchByTitle);
            $settingsFilter['specialToken'] = $settingsFilter['specialToken'] . $searchByTitle;
        }
        return ['parsing' => $parsing, 'settingsFilter' => $settingsFilter];
    } 
}