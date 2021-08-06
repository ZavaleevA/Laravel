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
            $parsing->created_at = date('Y-m-d H:i:s');;
            $parsing->save();
        }
        return redirect()->back()->with('success', 'Парсинг прошел успешно!');
    }

    public function allDataParsing(){
        return view('ads', ['data' => Parsing::all()->sortByDesc("dates")]);
    }

    public function dateAds($id){
        $parsing = new Parsing();
        return view('individualAds', ['data' => [$parsing->find($id)]]);
    } 
}