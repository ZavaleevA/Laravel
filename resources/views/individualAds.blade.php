@extends('layouts.app')
@foreach($data as $pars)
@section('title-block'){{$pars->title_name}} @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">            
            <div class="alert alert-info" align="center">
                <table border="0" align="center" width="100%" cellpadding="7" bordercolor="Black">
                <td align='center'>
                <img style="width: 75%; height: 75%;" src="{{$pars->url_image}}">
                </td><tr>
                </table><br> 
                <table border="0" style="color: Black;" align="center" width="100%" cellpadding="7" bordercolor="Black">
                <td bgcolor='white' rowspan="5" width="5%" valign="top"></td>
                <?
                    if (date("d m Y",strtotime($pars["dates"])) != date('d m Y')) {
                        $arr = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
                        $dateMonthRus = $arr[(date("m",strtotime($pars["dates"]))) - 1];
                        $finalDate = date("d",strtotime($pars["dates"])) . " " . $dateMonthRus . " " . date("Y",strtotime($pars["dates"]));
                    } else {
                        $finalDate = "cегодня";
                    }
                ?>  
                <td bgcolor='white' valign="top"><br>Опубликовано: {{$finalDate}}</td>
                <td bgcolor='white' rowspan="5" width="5%" valign="top"></td><tr>
                <td bgcolor='white' valign="top"><h2>{{$pars->title_name}}</h2></td><tr>
                <td bgcolor='white' valign="top"><h3><strong>{{$pars->price}}</strong></h3></td><tr>
                <td bgcolor='white' valign="top"><h4>{{$pars->year}}<br>{{$pars->type_of_fuel}}<br>{{$pars->mileage}}</h4></td><tr>
                <td bgcolor='white' valign="top"><h2><strong>Описание</strong></h2><h4>{{$pars->description}}</h4><br></td><tr>
                </table>
            </div>
            <br><br><br>
            @endforeach
        </div>
    </div>
</div>
@endsection