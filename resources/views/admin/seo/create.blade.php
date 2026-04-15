@extends('layouts.admin')
@section('title', 'Новая SEO запись')
@section('content')
<div class="px-4" style="max-width:700px">
    <h4 class="fw-bold mb-4">Новая SEO запись</h4>
    <form action="{{ route('admin.seo.store') }}" method="POST">
        @csrf
        @include('admin.seo._form')
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary ms-2">Отмена</a>
        </div>
    </form>
</div>
@endsection
