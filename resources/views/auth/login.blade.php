@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="app-brand justify-content-center mb-4">
            <span class="app-brand-text fw-bolder fs-2">VOID</span>
        </div>
        <h4 class="mb-1">Добро пожаловать</h4>
        <p class="mb-4 text-muted">Войдите в панель управления</p>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus/>
            </div>
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required/>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"/>
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">Войти</button>
        </form>
    </div>
</div>
@endsection
