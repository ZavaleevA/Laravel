@extends('layouts.app')

@section('title-block')Объявления @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>{{ ('Объявления') }}</h2>
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
                <td bgcolor='white' rowspan="2" width="13%" valign="top"><h3><strong>{{$pars->price}}</strong></h3></td><tr>

                <?
                if (date("d m Y",strtotime($pars["dates"])) != date('d m Y')) {
                    $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                    $dateMonthRus = $arr[(date("m",strtotime($pars["dates"]))) - 1];
                    $finalDate = date("d",strtotime($pars["dates"])) . " " . $dateMonthRus . " " . date("Y",strtotime($pars["dates"]));
                } else {
                    $finalDate = "cегодня";
                }
                ?>

                <td bgcolor='white' width="62%" valign="bottom">Опубликовано: {{$finalDate}}</td><tr>
                </table>
                </div>
            @endforeach
            <br>
            @if ($noComments == 0)
            <br><br><br><br><br><br><br>
            <h2 align="center"><strong>{{ ('😞Похоже, здесь нет еще объявлений😞') }}</strong></h2>
            @endif
        </div>
    </div>
</div>
@endsection