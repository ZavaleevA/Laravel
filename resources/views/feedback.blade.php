@extends('layouts.app')

@section('title-block')Обратная связь @endsection
<script src='https://www.google.com/recaptcha/api.js'></script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" align="center">
                    <h3><strong>{{('Здравствуйте, Вы находитесь на формре обратной связи с разработчиками сайта. Чтобы оправить письмо, необходимо заполнить все поля, что находяться ниже.')}}</strong></h3>
                </div>
                <div class="card-body" align="center">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif
                    <h3>
                    {{'Форма для обратной связи'}}<br>
                    </h3>
                    <form action="{{ route('data-feedback') }}" method="POST">
                        @csrf
                        <input type="name" class="form-control" name="name" id="name" placeholder="Введите имя"><br>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Введите email"><br>
                        <textarea class="form-control" name="text" id="text" rows="3" placeholder="Введите свое сообщения"></textarea><br>
                        <div class="g-recaptcha" data-sitekey="6LeJYcQcAAAAAJTtHe7gmzMHjnOvyKM2co_6TwI_"></div><br>
                        <button class="btn btn-success" type="submit">Отправить письмо</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection