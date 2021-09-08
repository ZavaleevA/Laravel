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
                    $idAds = $pars->id;
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
                    <?
                        $price = $pars->price;
                        $price = number_format($price, 0, ',', ' ');
                        $mileage = $pars->mileage;
                        $mileage = number_format($mileage, 0, ',', ' ');
                    ?>
                <td bgcolor='white' valign="top"><h3><strong>{{$price}} $</strong></h3></td><tr>
                <td bgcolor='white' valign="top"><h4>Год выпуска: {{$pars->year}}<br>Вид топлива: {{$pars->type_of_fuel}}<br>Пробег: {{$mileage}} км</h4></td><tr>
                <td bgcolor='white' valign="top"><h2><strong>Описание</strong></h2><h4>{{$pars->description}}</h4><br></td><tr>
                </table>
            </div>
            <br>
            @endforeach
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                    {{session('success')}}
                    </div>
                @endif
                @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
            <div class="card-body"  align="center">
                <h2>{{ ('Оставить комментарий') }}</h2>
                <p>Комментарий будет от Вашего имени: {{Auth::user()->name}}</p>
                <form action="{{ route('add-comment-ads', $pars->id) }}" method="POST">
                    @csrf
                    <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Ваш комментарий"></textarea><br>
                    <button class="btn btn-success" type="submit">Отправить комментарий</button>
                </form> 
            </div>
        </div>
        <br>
            </div> 
        </div>
    </div>
</div>   
@foreach((DB::table('comment_ads')->get()->reverse()) as $dataCommentAds)
    @if($dataCommentAds->ads_id == $idAds)
        <div class="alert alert-info" style="width:80%; float: right; margin-right: 10%;">
            <table border="0" width="100%" cellpadding="7">
                <td rowspan="2" width="17%">
                @if((($userAvatar = DB::table('users')->where('id', $dataCommentAds->user_id)->value('avatar')) != NULL) AND $noComments = 1)
                @elseif($userAvatar = '/storage/uploads/dog.jpg')
                @endif
                <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($dataCommentAds->created_at))}}
                @if (($dataCommentAds->updated_at) != NULL)
                    ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($dataCommentAds->updated_at))}} ✅
                @endif
                </td><tr>
                <td colspan="2" bgcolor='white'><h5>{{$dataCommentAds->text}}</h5></td><tr>
                <td align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $dataCommentAds->user_id)->value('name')}}</strong></td>
                @if((Auth::user()->id) == $dataCommentAds->user_id)
                    <td height="20%" colspan="2" bgcolor='white' align='right'><a style="color: White" class="btn btn-primary" href="{{ route('comment-ads-date-edit', $dataCommentAds->id) }}">Редактировать</a>
                    <a style="color: White" class="btn btn-danger" href="{{ route('comment-ads-delete', $dataCommentAds->id) }}">Удалить</a></td><tr>
                @elseif((Auth::user()->id) != $dataCommentAds->user_id)
                    <td height="20%" colspan="2" bgcolor='white' align='right'>
                    <a style="color: Black" class="btn btn-warning" href="{{ route('new-sub-comment-ads', $dataCommentAds->id) }}">Ответить</a></td><tr>
                @endif
            </table>
        </div>

        @foreach((DB::table('sub_comment_ads')->get()->reverse()) as $dataSubCommentAds)
            @if(($dataCommentAds->id == $dataSubCommentAds->id_comment) AND ($dataSubCommentAds->id_sub_comment == NULL))
                <div class="alert alert-danger" style="width:74%; float: right; margin-right: 10%;">
                    <table border="0" width="100%" cellpadding="7">
                        <td rowspan="2" width="17%">
                            @if((($userAvatar = DB::table('users')->where('id', $dataSubCommentAds->id_user)->value('avatar')) != NULL) AND $noComments = 1)
                            @elseif($userAvatar = '/storage/uploads/dog.jpg')
                            @endif
                            <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                            <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($dataSubCommentAds->created_at))}}
                            @if (($dataSubCommentAds->updated_at) != NULL)
                            ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($dataSubCommentAds->updated_at))}} ✅
                            @endif
                            </td><tr>
                        <td colspan="2" bgcolor='white'><h5>{{$dataSubCommentAds->text}}</h5></td><tr>
                        <td align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $dataSubCommentAds->id_user)->value('name')}}</strong></td>
                        @if((Auth::user()->id) == $dataSubCommentAds->id_user)
                            <td height="20%" colspan="2" bgcolor='white' align='right'><a style="color: White" class="btn btn-primary" href="{{ route('data-edit-sub-comment-ads', $dataSubCommentAds->id) }}">Редактировать</a>
                            <a style="color: White" class="btn btn-danger" href="{{ route('delete-sub-comment-ads', $dataSubCommentAds->id) }}">Удалить</a></td><tr>
                        @elseif((Auth::user()->id) != $dataSubCommentAds->id_user)
                        <td height="20%" colspan="2" bgcolor='white' align='right'>
                            <a style="color: Black" class="btn btn-warning" href="{{ route('data-sub-comment-ads', $dataSubCommentAds->id) }}">Ответить</a></td><tr>
                        @endif
                    </table>
                </div>
                
                @foreach((DB::table('sub_comment_ads')->get()->reverse()) as $dataReplySubCommentAds)
                    @if($dataSubCommentAds->id == $dataReplySubCommentAds->id_sub_comment)
                        <div class="alert alert-dark" style="width:68%; float: right; margin-right: 10%;">
                            <table border="0" width="100%" cellpadding="7">
                                <td rowspan="2" width="17%">
                                @if((($userAvatar = DB::table('users')->where('id', $dataReplySubCommentAds->id_user)->value('avatar')) != NULL) AND $noComments = 1)
                                @elseif($userAvatar = '/storage/uploads/dog.jpg')
                                @endif
                                <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                                <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($dataReplySubCommentAds->created_at))}}
                                @if (($dataReplySubCommentAds->updated_at) != NULL)
                                    ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($dataReplySubCommentAds->updated_at))}} ✅
                                @endif
                                </td><tr>
                                <td colspan="2" bgcolor='white'><h5>{{$dataReplySubCommentAds->text}}</h5></td><tr>
                                <td align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $dataReplySubCommentAds->id_user)->value('name')}}</strong></td>
                                @if((Auth::user()->id) == $dataReplySubCommentAds->id_user)
                                    <td height="20%" colspan="2" bgcolor='white' align='right'><a style="color: White" class="btn btn-primary" href="{{ route('date-reply-sub-comment-ads', $dataReplySubCommentAds->id) }}">Редактировать</a>
                                    <a style="color: White" class="btn btn-danger" href="{{ route('delete-reply-sub-comment-ads', $dataReplySubCommentAds->id) }}">Удалить</a></td><tr>
                                @endif
                            </table>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
@endforeach    
<br><br><br>        
@endsection