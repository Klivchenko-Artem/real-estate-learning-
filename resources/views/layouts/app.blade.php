<!DOCTYPE html>
<html lang="ru" class="light-style customizer-hide">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('assets/admin/js/manifest.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>
</html>
