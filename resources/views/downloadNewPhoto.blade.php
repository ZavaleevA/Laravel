@extends('layouts.app')

@section('title-block')Изменить аватар @endsection

@section('content')
<div class="container" align="center">
    <h1>Загрузите новое изображение</h1>
    <form action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <input type="file" name="image">
        </div><br>
        <button class="btn btn-primary" type="submit">Загрузить!</button>
        <a href="{{ route('home') }}" class="btn btn-success">Вернуться назад</a>
    </form><br>
    @isset($path)
    @if ($path != '')
        <img style="width: 80%; height: 80%;" class="img-fluid" src="{{asset('/storage/' . $path)}}">
    @endif
    @if ($path == '')
        <h3><strong>Вы не выбрали файл.</strong></h3>
    @endif
    @endisset
</div>
@endsection