@extends('layouts.app')

@section('title-block')Объявления @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ ('Объявления') }}</h2>          
            <table class="table table-bordered table-dark">
                <form action="{{route('filter-ads')}}" method="GET">
                @csrf
                <tr>
                    <th scope="col" colspan="2">Цена</th>
                    <th scope="col" colspan="2">Год выпуска</th>
                    <th scope="col" colspan="2">Пробег</th>
                </tr>
                <tr>
                    <td width="16%">
                        <select class="form-control" name="priceFrom">
                            <option value="0">от</option>
                            <option value="1">1000</option>
                            <option value="2">2000</option>
                            <option value="3">3000</option>
                            <option value="4">4000</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="priceBefore">
                            <option value="0">до</option>
                            <option value="1">1000</option>
                            <option value="2">2000</option>
                            <option value="3">3000</option>
                            <option value="4">4000</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="yearFrom">
                            <option value="0">от</option>
                            <option value="1">2000</option>
                            <option value="2">2005</option>
                            <option value="3">2010</option>
                            <option value="4">2015</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="yearBefore">
                            <option value="0">до</option>
                            <option value="1">2000</option>
                            <option value="2">2005</option>
                            <option value="3">2010</option>
                            <option value="4">2015</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="mileageFrom">
                            <option value="0">от</option>
                            <option value="1">50 000</option>
                            <option value="2">100 000</option>
                            <option value="3">150 000</option>
                            <option value="4">200 000</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="mileageBefore">
                            <option value="0">до</option>
                            <option value="1">100 000</option>
                            <option value="2">150 000</option>
                            <option value="3">200 000</option>
                            <option value="4">250 000</option>
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
                            <option value="0">Все</option>
                            <option value="1">Бензин</option>
                            <option value="2">Дизель</option>
                            <option value="3">Газ/бензин</option>
                            <option value="4">Электро</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="publicatedFrom">
                            <option value="0">от</option>
                            <option value="1">Сегодня</option>
                            <option value="2">Вчера</option>
                            <option value="3">Неделю назад</option>
                            <option value="4">Месяц назад</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select class="form-control" name="publicatedBefore">
                            <option value="0">по</option>
                            <option value="1">Сегодня</option>
                            <option value="2">Вчера</option>
                            <option value="3">Неделю назад</option>
                            <option value="4">Месяц назад</option>
                        </select>
                    </td>
                    <td width="16%" colspan="2">
                        <input class="form-control" name="searchByTitle" id="searchByTitle" placeholder="Введите название объявления">
                    </td>
                    
                </tr>
                </form>
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
                    <h2 align="center"><strong>{{ ('😞Похоже, здесь нет еще объявлений😞') }}</strong></h2>   
                </div>
            </div>
            @endif
        </div>
        {{$data->links("pagination::bootstrap-4")}}
    </div>
</div>
@endsection