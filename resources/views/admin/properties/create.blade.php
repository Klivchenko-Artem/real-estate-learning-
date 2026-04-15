@extends('layouts.admin')

@section('title', 'Новый объект')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.properties.index') }}">Объекты</a></li>
            <li class="breadcrumb-item active">Добавить</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="px-4">
    <h4 class="fw-bold mb-4">Добавить объект</h4>
    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.properties._form')
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary ms-2">Отмена</a>
        </div>
    </form>
</div>
@endsection
