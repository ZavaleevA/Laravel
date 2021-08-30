@extends('layouts.app')

@section('title-block')Отправить комментарий @endsection

@section('content')
<div class="container">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body"  align="center">
                    <h2>{{ ('Добавить комментарий') }}</h2>
                    <p>Комментарий будет от Вашего имени: {{Auth::user()->name}}</p>
                    <form action="{{ route('comment-form') }}" method="POST">
                        @csrf
                        <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Ваш комментарий"></textarea><br>
                        <button class="btn btn-success" type="submit">Отправить комментарий</button>
                    </form>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection