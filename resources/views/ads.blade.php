@extends('layouts.app')

@section('title-block')Объявления @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">                   
            <table class="table table-bordered table-dark">
                <form action="{{route('filter-ads')}}" method="GET">
                @csrf
                <tr>
                    <th scope="col" colspan="2">Цена</th>
                    <th scope="col" colspan="2">Год выпуска</th>
                    <th scope="col" colspan="2">Пробег</th>
                </tr>
                <tr>
                @foreach($settingsFilter as $settingsFilterAds)
                    <?
                    if ($settingsFilterAds == 'default') {
                        $priceFrom1 = $priceFrom2 = $priceFrom3 = $priceFrom4 = $priceBefore1 = $priceBefore2 = $priceBefore3 = $priceBefore4 = $yearFrom1 = $yearFrom2 = $yearFrom3 = $yearFrom4 = $yearBefore1 = $yearBefore2 = $yearBefore3 = $yearBefore4 = $mileageFrom1 = $mileageFrom2 = $mileageFrom3 = $mileageFrom4 = $mileageBefore1 = $mileageBefore2 = $mileageBefore3 = $mileageBefore4 = $fuel1 = $fuel2 = $fuel3 = $fuel4 = $publicatedFrom1 = $publicatedFrom2 = $publicatedFrom3 = $publicatedFrom4 = $publicatedBefore1 = $publicatedBefore2 = $publicatedBefore3 = $publicatedBefore4 = $searchByTitleText ='';
                            $specialToken = "default";
                    } else {    
                    $priceFrom1 = $settingsFilterAds['priceFrom1'];
                    $priceFrom2 = $settingsFilterAds['priceFrom2'];
                    $priceFrom3 = $settingsFilterAds['priceFrom3'];
                    $priceFrom4 = $settingsFilterAds['priceFrom4'];

                    $priceBefore1 = $settingsFilterAds['priceBefore1'];
                    $priceBefore2 = $settingsFilterAds['priceBefore2'];
                    $priceBefore3 = $settingsFilterAds['priceBefore3'];
                    $priceBefore4 = $settingsFilterAds['priceBefore4'];

                    $yearFrom1 = $settingsFilterAds['yearFrom1'];
                    $yearFrom2 = $settingsFilterAds['yearFrom2'];
                    $yearFrom3 = $settingsFilterAds['yearFrom3'];
                    $yearFrom4 = $settingsFilterAds['yearFrom4'];

                    $yearBefore1 = $settingsFilterAds['yearBefore1'];
                    $yearBefore2 = $settingsFilterAds['yearBefore2'];
                    $yearBefore3 = $settingsFilterAds['yearBefore3'];
                    $yearBefore4 = $settingsFilterAds['yearBefore4'];

                    $mileageFrom1 = $settingsFilterAds['mileageFrom1'];
                    $mileageFrom2 = $settingsFilterAds['mileageFrom2'];
                    $mileageFrom3 = $settingsFilterAds['mileageFrom3'];
                    $mileageFrom4 = $settingsFilterAds['mileageFrom4'];

                    $mileageBefore1 = $settingsFilterAds['mileageBefore1'];
                    $mileageBefore2 = $settingsFilterAds['mileageBefore2'];
                    $mileageBefore3 = $settingsFilterAds['mileageBefore3'];
                    $mileageBefore4 = $settingsFilterAds['mileageBefore4'];

                    $fuel1 = $settingsFilterAds['fuel1'];
                    $fuel2 = $settingsFilterAds['fuel2'];
                    $fuel3 = $settingsFilterAds['fuel3'];
                    $fuel4 = $settingsFilterAds['fuel4'];

                    $publicatedFrom1 = $settingsFilterAds['publicatedFrom1'];
                    $publicatedFrom2 = $settingsFilterAds['publicatedFrom2'];
                    $publicatedFrom3 = $settingsFilterAds['publicatedFrom3'];
                    $publicatedFrom4 = $settingsFilterAds['publicatedFrom4'];

                    $publicatedBefore1 = $settingsFilterAds['publicatedBefore1'];
                    $publicatedBefore2 = $settingsFilterAds['publicatedBefore2'];
                    $publicatedBefore3 = $settingsFilterAds['publicatedBefore3'];
                    $publicatedBefore4 = $settingsFilterAds['publicatedBefore4'];

                    $specialToken = $settingsFilterAds['specialToken'];
                    }
                    $sheyTso = 1;
                    ?>
                @endforeach
                    <td width="16%">
                        <select class="form-control" name="priceFrom">
                            <option value="0" selected>от</option>
                            <option value="1" {{$priceFrom1}}>1000</option>
                            <option value="2" {{$priceFrom2}}>2000</option>
                            <option value="3" {{$priceFrom3}}>3000</option>
                            <option value="4" {{$priceFrom4}}>4000</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="priceBefore">
                            <option value="0" selected>до</option>
                            <option value="1" {{$priceBefore1}}>1000</option>
                            <option value="2" {{$priceBefore2}}>2000</option>
                            <option value="3" {{$priceBefore3}}>3000</option>
                            <option value="4" {{$priceBefore4}}>4000</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="yearFrom">
                            <option value="0" selected>от</option>
                            <option value="1" {{$yearFrom1}}>2000</option>
                            <option value="2" {{$yearFrom2}}>2005</option>
                            <option value="3" {{$yearFrom3}}>2010</option>
                            <option value="4" {{$yearFrom4}}>2015</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="yearBefore">
                            <option value="0" selected>до</option>
                            <option value="1" {{$yearBefore1}}>2000</option>
                            <option value="2" {{$yearBefore2}}>2005</option>
                            <option value="3" {{$yearBefore3}}>2010</option>
                            <option value="4" {{$yearBefore4}}>2015</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="mileageFrom">
                            <option value="0" selected>от</option>
                            <option value="1" {{$mileageFrom1}}>50 000</option>
                            <option value="2" {{$mileageFrom2}}>100 000</option>
                            <option value="3" {{$mileageFrom3}}>150 000</option>
                            <option value="4" {{$mileageFrom4}}>200 000</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="mileageBefore">
                            <option value="0" selected>до</option>
                            <option value="1" {{$mileageBefore1}}>100 000</option>
                            <option value="2" {{$mileageBefore2}}>150 000</option>
                            <option value="3" {{$mileageBefore3}}>200 000</option>
                            <option value="4" {{$mileageBefore4}}>250 000</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="col" colspan="1">Вид топлива</th>
                    <th scope="col" colspan="2">Опубликовано</th>
                    <th scope="col" colspan="2">Поиск по названию</th>
                    <th scope="col" rowspan="2" class="text-center">
                        <a href="{{route('all-data-parsing')}}" class="btn btn-warning" type="submit">Сбросить фильтр</a>
                        <br><br>
                        <button class="btn btn-success" type="submit">Применить фильтр</button>
                    </th>
                </tr>

                <tr>
                    <td width="16%">
                        <select class="form-control" name="fuel">
                            <option value="0" selected>Все</option>
                            <option value="1" {{$fuel1}}>Бензин</option>
                            <option value="2" {{$fuel2}}>Дизель</option>
                            <option value="3" {{$fuel3}}>Газ/бензин</option>
                            <option value="4" {{$fuel4}}>Электро</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="publicatedFrom">
                            <option value="0" selected>от</option>
                            <option value="1" {{$publicatedFrom1}}>Сегодня</option>
                            <option value="2" {{$publicatedFrom2}}>Вчера</option>
                            <option value="3" {{$publicatedFrom3}}>Неделю назад</option>
                            <option value="4" {{$publicatedFrom4}}>Месяц назад</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="publicatedBefore">
                            <option value="0" selected>по</option>
                            <option value="1" {{$publicatedBefore1}}>Сегодня</option>
                            <option value="2" {{$publicatedBefore2}}>Вчера</option>
                            <option value="3" {{$publicatedBefore3}}>Неделю назад</option>
                            <option value="4" {{$publicatedBefore4}}>Месяц назад</option>
                        </select>
                    </td>
                    <td width="16%" colspan="2">
                        <input class="form-control" name="searchByTitle" id="searchByTitle" placeholder="Введите название объявления">
                    </td>
                    
                </tr>
                </form>
            </table>

            <table class="table table-dark table-borderless">
                <tr>
                    <th scope="col">Сортировка:</th>
                    <th scope="col" class="text-center"><a style="color: white;" href="{{route('sort-by-date', $specialToken)}}">По дате</a></th>
                    <th scope="col" class="text-center"><a style="color: white;" href="{{route('sort-from-dear', $specialToken)}}">От дорогих ⮯</a></th>
                    <th scope="col" class="text-center"><a style="color: white;" href="{{route('sort-from-cheap', $specialToken)}}">От дешевых ⮭</a></th>
                    <th scope="col" class="text-center"><a style="color: white;" href="{{route('sort-from-new', $specialToken)}}">От новых</a></th>
                    <th scope="col" class="text-center"><a style="color: white;" href="{{route('sort-from-old', $specialToken)}}">От старых</a></th>
                    <th scope="col" class="text-center"><a style="color: white;" href="{{route('sort-by-mileage', $specialToken)}}">По пробегу ⮭</a></th>
                </tr>
            </table>

            @if ($noComments = 0)
            @endif
            @foreach($data as $pars)
            @if ($noComments = 1)
            @endif
                <div class="alert alert-info">
                <table border="0" width="100%" cellpadding="7">
                <td bgcolor='white' rowspan="2" width="25%" align='fleft'>
                    <a style="color: Black;" href="{{route('date-ads', $pars->id)}}">
                        <img style="width: 100%; height: 100%;" src="{{$pars->url_image}}">
                    </a>
                </td>
                <td bgcolor='white' width="62%" valign="top">
                    <h3>
                    <a style="color: Black;" href="{{route('date-ads', $pars->id)}}">
                    <strong>{{$pars->title_name}}</strong>
                    </a>
                    </h3>
                </td>

                <?
                    $price = $pars->price;
                    $price = number_format($price, 0, ',', ' ');

                if (date("d m Y",strtotime($pars["dates"])) != date('d m Y')) {
                    $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                    $dateMonthRus = $arr[(date("m",strtotime($pars["dates"]))) - 1];
                    $finalDate = date("d",strtotime($pars["dates"])) . " " . $dateMonthRus . " " . date("Y",strtotime($pars["dates"]));
                } else {
                    $finalDate = "cегодня";
                }
                ?>

                <td bgcolor='white' rowspan="2" width="13%" valign="top"><h3><strong>{{$price}} $</strong></h3></td><tr>
                <td bgcolor='white' width="62%" valign="bottom">Опубликовано: {{$finalDate}}</td><tr>
                </table>
                </div>
            @endforeach
            @if ($noComments == 0)
            <div class="row justify-content-center">
                <div class="col-md-11" style="margin-top: 13%;"> 
                    <h2 align="center"><strong>{{ ('😞Похоже, здесь нет еще таких объявлений😞') }}</strong></h2>   
                </div>
            </div>
            @endif
        </div>
        {{$data->links("pagination::bootstrap-4")}}
    </div>
</div>
@endsection