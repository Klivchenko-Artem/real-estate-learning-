<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VOID') }}</title>
    @vite(['resources/client/app.ts'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
