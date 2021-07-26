@extends('layouts.app')

@section('title-block')Домашняя страница@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body" align="center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <?php
                        if (Auth::user()->avatar != NULL){
                            $avatar = Auth::user()->avatar;
                        } else {
                            $avatar = asset('/storage/uploads/dog.jpg');
                        }
                    ?>
                    <img style="width: 90%; height: 90%;" src="{{$avatar}}">
                    <br><br>
                    <h2>{{Auth::user()->name}}{{ __(', Вы вошли в систему!') }}</h2>  
                </div>
                <div class="card-header" align="center">
                    <h3>{{('⬇ Ваши данные выведены ниже в таблице ⬇')}}</h3>
                    <table border="3" align="center" width="75%" cellpadding="5" bgcolor="#99dedc" bordercolor="white">
                    <td>Name</td><td>Email</td><td>Password</td><tr>
                    <td>{{Auth::user()->name}}</td> <td>{{Auth::user()->email}}</td> <td> ******* </td><tr>
                    </table>
                </div>
                <div class="card-body" align="center">
                    <h3>
                    {{'Форма изменения данных'}}<br>
                    {{'Можно изменить все значения сразу, либо одно'}}
                    </h3>
                    <form action="validation_form/newUserDate" method="POST">
                        @csrf
                        <textarea class="form-control" name="name" id="name" rows="1">{{Auth::user()->name}}</textarea><br>
                        <input type="password" class="form-control" name="passNew" id="passNew" placeholder="Введите новый пароль"><br>
                        <input type="password" class="form-control" name="passNewСonfirm" id="passNewСonfirm" placeholder="Подтвердите новый пароль"><br>
                        <button class="btn btn-success" type="submit">Изменить данные</button>
                        <a href="downloadNewPhoto" class="btn btn-primary">Поменять фото</a>
                        <a href="{{ route('image.delete') }}" class="btn btn-danger" >Удалить фото</a><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection