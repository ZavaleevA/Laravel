@extends('layouts.app')

@section('title-block')Комментарии @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h2>{{ ('Комментарии') }}</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                    {{session('success')}}
                    </div>
                @endif
                @if ($noComments = 0)
                @endif
                @foreach($data->reverse() as $el)
                    <div class="alert alert-info">
                        <table border="0" width="100%" cellpadding="7">
                        <td rowspan="2" width="17%">
                        @if((($userAvatar = DB::table('users')->where('id', $el->user_id)->value('avatar')) != NULL) AND $noComments = 1)
                        @elseif($userAvatar = '/storage/uploads/dog.jpg')
                        @endif
                        <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                        <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($el->created_at))}}
                        @if (($el->updated_at) != NULL)
                            ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($el->updated_at))}} ✅
                        @endif
                        </td><tr>
                        <td colspan="2" bgcolor='white'><h5>{{$el->text}}</h5></td><tr>
                        <td align='center' style="color: Black;"><strong>{{$el->name}}</strong></td>
                        @if((Auth::user()->id) == $el->user_id)
                            <td height="20%" colspan="2" bgcolor='#9db2d4' align='right'><a style="color: Black;"  href="{{ route('comment-date-edit', $el->id) }}">Редактировать</a>
                            <a style="color: Black;" href="{{ route('comment-delete', $el->id) }}">🔥Удалить🔥</a></td><tr>
                        @elseif((Auth::user()->id) != $el->user_id)
                            <td height="20%" colspan="2" bgcolor='#9db2d4' align='right'>
                            <a style="color: Black;" href="#">Ответить</a></td><tr>
                        @endif
                        </table>
                    </div>    
                @endforeach
                @if ($noComments == 0)
                <br><br><br><br><br><br><br>
                <h2 align="center"><strong>{{ ('😞Похоже, здесь нет еще комментариев😞') }}</strong></h2>
                @endif
        </div>
    </div>
</div>
@endsection