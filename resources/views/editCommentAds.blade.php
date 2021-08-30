@extends('layouts.app')

@section('title-block')Редактировать комментарий @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('editSuccess'))
                <div class="alert alert-success">
                    {{session('editSuccess')}}
                </div>
            @endif
            @if (session('editError'))
                <div class="alert alert-danger">
                    {{session('editError')}}
                </div>
            @endif
            <div class="card">
                <div class="card-body"  align="center">
                    <h2>{{ ('Редактировать комментарий') }}</h2>
                    <p>{{Auth::user()->name}}, комментарий будет отредоктирован сразу после нажатия кнопки</p>
                    @foreach($data as $el)
                    <form action="{{ route('comment-ads-edit', $el->id) }}" method="POST">
                        @csrf
                        <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Ваш комментарий">{{$el->text}}</textarea><br>
                        <button class="btn btn-warning" type="submit">Редактировать комментарий</button>
                        <a href="{{route('date-ads', $el->ads_id)}}" class="btn btn-info" >Назад</a>
                    </form>  
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection