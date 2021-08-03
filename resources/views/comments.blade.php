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
                        <td align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $el->user_id)->value('name')}}</strong></td>
                        @if((Auth::user()->id) == $el->user_id)
                            <td height="20%" colspan="2" bgcolor='white' align='right'><a style="color: White;" class="btn btn-primary" href="{{ route('comment-date-edit', $el->id) }}">Редактировать</a>
                            <a style="color: White;" class="btn btn-danger" href="{{ route('comment-delete', $el->id) }}">Удалить</a></td><tr>
                        @elseif((Auth::user()->id) != $el->user_id)
                            <td height="20%" colspan="2" bgcolor='white' align='right'>
                            <a style="color: Black;" class="btn btn-warning" href="{{ route('new-sub-comment', $el->id) }}">Ответить</a></td><tr>
                        @endif
                        </table>
                    </div>
                    
                    @foreach ((DB::table('sub_comments')->get()->reverse()) as $subComment)

                    @if(($el->id) == ($subComment->id_comment) AND (($subComment->id_sub_comment) == NULL))
                    <div class="col-md-11">
                    <div class="alert alert-danger">
                        <table border="0" width="100%" cellpadding="7">
                        <td rowspan="2" width="17%">
                        @if((($userAvatar = DB::table('users')->where('id', $subComment->id_user)->value('avatar')) != NULL) AND $noComments = 1)
                        @elseif($userAvatar = '/storage/uploads/dog.jpg')
                        @endif
                        <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                        <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($subComment->created_at))}}
                        @if (($subComment->updated_at) != NULL)
                            ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($subComment->updated_at))}} ✅
                        @endif
                        </td><tr>
                        <td colspan="2" bgcolor='white'><h5>{{$subComment->text}}</h5></td><tr>
                        <td align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $subComment->id_user)->value('name')}}</strong></td>
                        @if((Auth::user()->id) == $subComment->id_user)
                            <td height="20%" colspan="2" bgcolor='white' align='right'><a style="color: White;" class="btn btn-primary" href="{{ route('date-edit-sub-comment', $subComment->id) }}">Редактировать</a>
                            <a style="color: White;" class="btn btn-danger" href="{{ route('delete-sub-comment', $subComment->id) }}">Удалить</a></td><tr>
                        @elseif((Auth::user()->id) != $subComment->id_user)
                            <td height="20%" colspan="2" bgcolor='white' align='right'>
                            <a style="color: Black;" class="btn btn-warning" href="{{ route('date-sub-comment', $subComment->id) }}">Ответить</a></td><tr>
                        @endif
                        </table>
                        </div>
                    </div>
                    @endif

                    @foreach ((DB::table('sub_comments')->get()->reverse()) as $replySubComment)

                    @if(($subComment->id) == ($replySubComment->id_sub_comment) AND ($el->id) == ($subComment->id_comment))
                        <div class="col-md-10">
                            <div class="alert alert-dark">
                                <table border="0" width="100%" cellpadding="7">
                                <td rowspan="2" width="17%">
                                @if((($userAvatar = DB::table('users')->where('id', $replySubComment->id_user)->value('avatar')) != NULL) AND $noComments = 1)
                                @elseif($userAvatar = '/storage/uploads/dog.jpg')
                                @endif
                                <img style="width: 100%; height: 100%;" src="{{asset($userAvatar)}}"></td>
                                <td height="20%" bgcolor='#c38cd4' align='right' style="color: Black;">Отправлено: {{date("d.m.y ⌚H:i",strtotime($replySubComment->created_at))}}
                                @if (($replySubComment->updated_at) != NULL)
                                ✅ Ред. {{date("d.m.y ⏰H:i",strtotime($replySubComment->updated_at))}} ✅
                                @endif
                                </td><tr>
                                <td colspan="2" bgcolor='white'><h5>{{$replySubComment->text}}</h5></td><tr>
                                <td rowspan="2" align='center' style="color: Black;"><strong>{{DB::table('users')->where('id', $replySubComment->id_user)->value('name')}}</strong></td>
                                @if((Auth::user()->id) == $replySubComment->id_user)
                                    <td height="20%" colspan="2" bgcolor='white' align='right'><a style="color: White;" class="btn btn-primary" href="{{ route('date-reply-sub-comment', $replySubComment->id) }}">Редактировать</a>
                                    <a style="color: White;" class="btn btn-danger" href="{{ route('delete-reply-sub-comment', $replySubComment->id) }}">Удалить</a></td><tr>
                                @endif
                                </table>
                            </div>
                        </div>
                    @endif
                    @endforeach

                    @endforeach

                @endforeach
                @if ($noComments == 0)
                <br><br><br><br><br><br><br>
                <h2 align="center"><strong>{{ ('😞Похоже, здесь нет еще комментариев😞') }}</strong></h2>
                @endif
        </div>
    </div>
</div>
@endsection