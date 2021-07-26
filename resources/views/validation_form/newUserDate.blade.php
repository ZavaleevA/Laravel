<?php
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$passNew = filter_var(trim($_POST['passNew']), FILTER_SANITIZE_STRING);
$passNewСonfirm = filter_var(trim($_POST['passNewСonfirm']), FILTER_SANITIZE_STRING);

if ($name != ''){
    if ($name != Auth::user()->name){
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['name' => $name]);
        $name = "Имя обновлено! ";
    } else {
        $name = "";
    }
} else {
    $name = "Вы не ввели новое имя!";
}

if ($passNew != ''){
    if ($passNew >= 8){
        if ($passNewСonfirm != ''){
            if ($passNewСonfirm == $passNew){
                $hashedPassword = Hash::make($passNew);
                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['password' => $hashedPassword]);
                $passNew = "Пароль успешно обновлен!";
            } else {
                $passNew = "Повторный пароль введен не верно!";
            }
        } else {
            $passNew = "Вы не ввели повторно новый пароль!";
        }   
    } else {
        $passNew = "Слишком короткий пароль, пожалуйста, введите от 8 символов";    
    }
}

if ($name == $passNew){
    $name = "Данные не изменились!";
}
?>

@extends('layouts.app')

@section('title-block')Изменение данных@endsection

@section('content')
<div class="container" align="center">
    <h1>{{$name}}{{$passNew}}</h1><br>  
    <a href="{{ route('home') }}" class="btn btn-primary">Вернуться домой</a> 
</div>
@endsection