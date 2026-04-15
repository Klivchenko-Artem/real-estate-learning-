@extends('layouts.admin')
@section('title', 'Настройки')
@section('content')
<div class="px-4">
    <h4 class="fw-bold mb-4">Настройки сайта</h4>
    <form action="{{ route('admin.settings.update') }}" method="POST" style="max-width:700px">
        @csrf

        <div class="card mb-4">
            <div class="card-header fw-semibold">Главная страница</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Заголовок героя</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] }}"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Подзаголовок героя</label>
                    <input type="text" name="hero_subtitle" class="form-control" value="{{ $settings['hero_subtitle'] }}"/>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold">Статистика</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Лет опыта</label>
                    <input type="number" name="experience_years" class="form-control" value="{{ $settings['experience_years'] }}"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Довольных клиентов</label>
                    <input type="number" name="clients_count" class="form-control" value="{{ $settings['clients_count'] }}"/>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-semibold">Контакты</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] }}"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $settings['email'] }}"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Адрес</label>
                    <input type="text" name="address" class="form-control" value="{{ $settings['address'] }}"/>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
