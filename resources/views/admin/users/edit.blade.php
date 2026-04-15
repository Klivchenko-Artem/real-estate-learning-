@extends('layouts.admin')
@section('title', 'Профиль')
@section('content')
<div class="px-4" style="max-width:500px">
    <h4 class="fw-bold mb-4">Профиль</h4>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required/>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required/>
        </div>
        <div class="mb-3">
            <label class="form-label">Новый пароль</label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="mb-3">
            <label class="form-label">Подтвердить пароль</label>
            <input type="password" name="password_confirmation" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
