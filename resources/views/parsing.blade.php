@extends('layouts.app')

@section('title-block')Парсинг @endsection

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
                    <h2>{{ ('Парсинг сайта по ссылке') }}</h2>
                    <p>{{Auth::user()->name}}, вставьте ссылку и нажмите на кнопку</p>
                    <form action="{{ route('new-parsing') }}" method="POST">
                        @csrf
                        <textarea class="form-control" name="url" id="url" rows="2" placeholder="Ваша ссылка"></textarea><br>
                        <button class="btn btn-success" type="submit">Парсить</button>
                    </form>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection