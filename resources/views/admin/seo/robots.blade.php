@extends('layouts.admin')
@section('title', 'Robots.txt')
@section('content')
<div class="px-4" style="max-width:700px">
    <h4 class="fw-bold mb-4">Robots.txt</h4>
    <form action="{{ route('admin.robots.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="robots_txt" class="form-control font-monospace" rows="15">{{ $robots }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
