@extends('layouts.app')

@section('title-block')Изменение данных@endsection

@section('content')
<div class="container" align="center">
    @if (session('newData'))
        <div class="alert alert-success">
            <h1>{{session('newData')}}</h1><br>
        </div>
    @endif  
    <a href="{{ route('home') }}" class="btn btn-primary">Вернуться домой</a> 
</div>
@endsection