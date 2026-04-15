@extends('layouts.admin')
@section('title', 'Редактировать SEO')
@section('content')
<div class="px-4" style="max-width:700px">
    <h4 class="fw-bold mb-4">SEO: {{ $seo->url }}</h4>
    <form action="{{ route('admin.seo.update', $seo) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.seo._form')
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary ms-2">Отмена</a>
        </div>
    </form>
</div>
@endsection
