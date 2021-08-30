@extends('layouts.app')

@section('title-block')Ответить на комментарий @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            @if (session('errorReplySubComment'))
                <div class="alert alert-danger">
                    {{session('errorReplySubComment')}}
                </div>
            @endif
            @if (session('successReplySubComment'))
                    <div class="alert alert-success">
                    {{session('successReplySubComment')}}
                    </div>
                @endif
            @foreach($data as $comment)
                <div class="alert alert-info">
                    <h2>{{ ('Вы отвечаете на этот комментарий:') }}</h2>
                    <table border="0" width="100%" cellpadding="7">
                        <td rowspan="2" width="17%">
                        @if((($userAvatar = DB::table('users')->where('id', $comment->id_user)->value('avatar')) != NULL) AND $noComments = 1)
                        @elseif($userAvatar = '/storage/uploads/dog.jpg')
                        @endif
                        <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                        <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($comment->created_at))}}
                        @if (($comment->updated_at) != NULL)
                            ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($comment->updated_at))}} ✅
                        @endif
                        </td><tr>
                        <td colspan="2" bgcolor='white'><h5>{{$comment->text}}</h5></td><tr>
                        <td align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $comment->id_user)->value('name')}}</strong></td>
                        <td height="20%" colspan="2" bgcolor='white' align='right'>
                        <a style="color: Black;" class="btn btn-warning" href="{{route('date-ads', DB::table('comment_ads')->where('id', $comment->id_comment)->value('ads_id'))}}">Отмена</a></td><tr>
                        </table>
                </div>
            @endforeach
        </div>    
        <div class="col-md-8">    
            <div class="card">
                <div class="card-body"  align="center">
                    <h2>{{ ('Ответить на комментарий') }}</h2>
                    <p>{{Auth::user()->name}}, ответ будет отправлен сразу после нажатия кнопки</p>
                    <form action="{{ route('add-reply-sub-comment-ads', $comment->id) }}" method="POST">
                        @csrf
                        <textarea class="form-control" name="newReplySubComment" id="newReplySubComment" rows="3" placeholder="Ваш ответ накомментарий"></textarea><br>
                        <button class="btn btn-warning" type="submit">Ответить</button>
                        <a href="{{route('date-ads', DB::table('comment_ads')->where('id', $comment->id_comment)->value('ads_id'))}}" class="btn btn-info" >Назад</a>
                    </form>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection