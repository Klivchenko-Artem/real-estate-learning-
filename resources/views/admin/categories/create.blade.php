@extends('layouts.admin')
@section('title', 'Новая категория')
@section('content')
<div class="px-4">
    <h4 class="fw-bold mb-4">Новая категория</h4>
    <form action="{{ route('admin.categories.store') }}" method="POST" style="max-width:500px">
        @csrf
        @include('admin.categories._form')
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">Отмена</a>
        </div>
    </form>
</div>
@endsection
